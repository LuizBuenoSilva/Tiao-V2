import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import { SongList } from './components/SongList';  // Note a mudança no caminho

function App() {
  return (
    <Router>
      <Routes>
        <Route path="/" element={<SongList />} />
      </Routes>
    </Router>
  );
}

export default App;