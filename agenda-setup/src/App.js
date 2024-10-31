import React, {useState, useEffect, Suspense} from "react"
import { SelectControl, RadioControl } from '@wordpress/components';
import Reorganize from './Reorganize'
import {useBlocks} from './queries.js';

function App() {
  return (
    <div className="App">
      <Reorganize />
    </div>
  );
}

export default App;
