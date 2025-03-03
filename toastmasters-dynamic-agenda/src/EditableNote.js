import React, { useRef, useEffect, useState } from 'react';
import { Editor } from '@tinymce/tinymce-react';
import apiClient from './http-common.js';
import {useQuery,useMutation, useQueryClient} from 'react-query';
import {SanitizedHTML} from './SanitizedHTML.js';
import { __experimentalNumberControl as NumberControl, TextControl } from '@wordpress/components';
import {initChangeBlockAttribute,updateAgenda} from './queries.js'

export function EditableNote(props) {
    const editorRef = useRef(null);
    const {post_id, block, makeNotification, insertBlock, blockindex, setInsert} = props;
    const [att,setAtt] = useState(block.attrs);
    const [submitted,setSubmitted] = useState(false);

    const {mutate:agendaMutate} = updateAgenda(post_id, makeNotification);
    const changeBlockAttribute = initChangeBlockAttribute(post_id,blockindex);

    function save() {
      if(insertBlock) {
        setAtt((oldatt) => {return {...oldatt,'uid': Date.now()}});
        insertBlock(blockindex,att,'wp4toastmasters/agendaedit','',editorRef.current.getContent());//no inner html, edithtml
        setInsert('');
      } else {
        const change = changeBlockAttribute('editable',att.editable);
        agendaMutate(change);
        const submitnote = {'note':editorRef.current.getContent(),'uid':att.uid,'post_id':props.post_id,'editable':att.editable};
        editEditable.mutate(submitnote);
      }
  }

  const queryClient = useQueryClient();

  const editEditable = useMutation(
      (edit) => { apiClient.post("editable_note_json", edit)},
      {

        onMutate: async (edit) => {
          await queryClient.cancelQueries(['blocks-data',post_id]);
          const previousData = queryClient.getQueryData(['blocks-data',post_id]);
          queryClient.setQueryData(['blocks-data',post_id],(oldQueryData) => {
              //function passed to setQueryData
              const {data} = oldQueryData;
              const {blocksdata} = data;
              blocksdata[blockindex].edithtml = edit.note;
              const newdata = {
                  ...oldQueryData, data: {...data,blocksdata: blocksdata}
              };
              return newdata;
  }) 
          makeNotification('Updating ...');
          setSubmitted(true);
          return {previousData}
      },
        // On failure, roll back to the previous value
        onError: (err, variables, previousValue) => {
          makeNotification('Error updating editable note '+err.message);
          console.log('error updating editable note',err);
          queryClient.setQueryData(['blocks-data',post_id], previousValue);
        },
        // After success or failure, refetch the todos query
        onSettled: (data, error, variables, context) => {
          queryClient.invalidateQueries(['blocks-data',variables.post_id]);
      },
      onSuccess: (data, error, variables, context) => {
          makeNotification('Updated');
      },
    }
  );

  if(!submitted && ((['edit','reorganize'].includes(props.mode)) || insertBlock))
  return (
    <>
    <h3>{att.editable}</h3>
    <p><TextControl label="heading" value={att.editable} onChange={ (title) => {setAtt( (prev) => {return {...prev,'editable':title} } )} }  /></p>
      <Editor
        onInit={(evt, editor) => editorRef.current = editor}
        initialValue={block.edithtml}
        init={{
          height: 100,
          menubar: false,
          toolbar: 'undo redo | bold italic | removeformat',
          content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        }}
      />
<>{insertBlock && <div className="tmflexrow"><div className="tmflex30"><NumberControl label="Time Allowed" value={att.time_allowed} onChange={ (value) => { setAtt((prev) => { return {...prev,time_allowed:value} }  ); }} /></div></div>}</>            
<p><button className="tmform" onClick={save}>Update</button></p>
<p><em>Editable notes are for content that changes from meeting to meeting, such as a meeting theme.</em></p>
    </>
  );

  //view logic 
  return (
    <>
    <h3>{att.editable}</h3>
    <SanitizedHTML innerHTML={block.edithtml} />
    {(submitted && (('edit' == props.mode) || insertBlock)) && <p><button onClick={() => setSubmitted(false)}>Edit</button></p>}
    </>
  );
}