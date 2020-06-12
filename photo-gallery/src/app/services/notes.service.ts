import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class NotesService {
  
  public note: Note[] = [];

  public notes = [];

  constructor() { }

  public async addNote(note: Note) {
    console.log("noteService", note.title, note.text);

    if (localStorage.getItem('notes')) {
      this.notes = JSON.parse(localStorage.getItem('notes'));
      this.notes.push(note);

    } else {
      this.notes.push(note);
    }

    localStorage.setItem('notes', JSON.stringify(this.notes));

    this.getNotes();
  }

  public getNotes() {
    this.note = JSON.parse(localStorage.getItem('notes'));
  }

  public deleteNote(position) {
    console.log(position);

    var notes = JSON.parse(localStorage.getItem("notes"));

    if (notes[position]) {
      var lastNote = notes.splice(position, 1);

      console.log(lastNote);
    }
    
    notes = JSON.stringify(notes);
    localStorage.setItem("notes", notes);

    this.getNotes();
  }

  public updateNote(position) {
    console.log(position);

    var notes = JSON.parse(localStorage.getItem("notes"));

    if (notes[position]) { 
      console.log("title: ", notes[position].title);
      
      this.deleteNote(position);

      return { 
        title: notes[position].title,
        text: notes[position].text,
      };
      
    }
    return {};
  }
}

interface Note {
  title: string;
  text: string;
}