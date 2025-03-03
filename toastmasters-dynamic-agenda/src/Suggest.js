import React, { useRef, useState } from 'react';
import { Editor } from '@tinymce/tinymce-react';
import { RadioControl } from '@wordpress/components';
import {SelectCtrl} from './Ctrl.js'
import { SanitizedHTML } from './SanitizedHTML';

export default function Suggest(props) {
  const editorRef = useRef(null);
  const [member,setMember] = useState(0);
  const [ccme,setCcme] = useState('0');
  const [notification,setNotification] = useState(null);
  function makeNotification(message, error = false, rawhtml = '') {
    setNotification({'message':message,'error':error,'rawHTML':rawhtml});
    setTimeout(() => {
        setNotification(null);
    },15000);
}

function send() {
  if(!member) {
    setNotification({'message':'No recipient selected','error':true});
    return;
  }
    if (editorRef.current) {
        let message = editorRef.current.getContent();
        console.log(message + 'from '+props.current_user_id+' to '+member+' for post '+props.post_id+' '+props.roletag);
        let url = wpt_rest.url + 'rsvptm/v1/tm_role?tm_ajax=role';
        const formData = new FormData();
        formData.append('role', props.roletag);
        formData.append('user_id', member);
        formData.append('editor_id', props.current_user_id);
        formData.append('post_id', props.post_id);
        formData.append('timelord', rsvpmaker_rest.timelord);
        formData.append('suggest_note', message);
        formData.append('ccme', ccme);
        fetch(url, {
            method: 'POST', // *GET, POST, PUT, DELETE, etc.
            headers: {
              'X-WP-Nonce': wpt_rest.nonce,
            },
            body: formData
          })
        .then((response) => {return response.json()})
        .then((responsedata) => {
            console.log(responsedata);
            makeNotification('Message sent',false,responsedata.content);
                });
            }
}

  return (
    <>
    <SelectCtrl label="Member to Nominate" value={member} options={props.memberoptions} onChange={(id) => { setMember(id); }} />
      <Editor
        onInit={(evt, editor) => editorRef.current = editor}
        initialValue={"I am nominating you for a role!"}
        init={{
          height: 100,
          menubar: false,
          toolbar: 'undo redo | bold italic | removeformat',
          content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        }}
      />
      <RadioControl selected={ccme} label="Send To" onChange={(value)=> setCcme(value)} options={[{'label': 'Member', 'value':'0'},{'label': 'Member + CC me', 'value':'1'},{'label': 'Me Only', 'value':'2'}]}/>
      {notification && <><div className={notification.error ? "tm-notification tm-notification-error suggestion-notification": "tm-notification tm-notification-success suggestion-notification"}>{notification.message}</div></>}
      {notification && notification.rawHTML && <div className="suggestion-preview"><SanitizedHTML innerHTML={notification.rawHTML} /></div>}
      {(!notification || notification.error) && <p><button className="tmform" type="primary" onClick={send}>Send Suggestion</button></p>}
    </>
  );
}