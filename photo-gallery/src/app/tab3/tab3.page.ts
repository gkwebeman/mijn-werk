import { Component, OnInit } from '@angular/core';

import { NotesService } from '../services/notes.service';

import { ActionSheetController, AlertController } from '@ionic/angular';

@Component({
  selector: 'app-tab3',
  templateUrl: 'tab3.page.html',
  styleUrls: ['tab3.page.scss']
})
export class Tab3Page implements OnInit{

  title: string;
  text: string;

  constructor(public noteService: NotesService,
            public actionSheetController: ActionSheetController,
            public alertController: AlertController) {
    
  }

  ngOnInit(){
    this.noteService.getNotes()
  }

  public processForm() {
    console.log(this.title, this.text);

    if (!this.title && !this.text) {
      console.log("vul wat in");
      this.presentAlert();
    } else {
      this.noteService.addNote({
        title: this.title,
        text: this.text,
      });
      this.title = "";
      this.text = "";
    }
  }

  async presentAlert() {
    const alert = await this.alertController.create({
      header: 'Let op!',
      message: 'Vul een titel of een text in.',
      buttons: ['OK']
    });

    await alert.present();
  }

  public async showActionSheet(position) {
    const actionSheet = await this.actionSheetController.create({
      header: 'Notes',
      buttons: [{
        text: 'Delete',
        role: 'destructive',
        icon: 'trash',
        handler: () => {
          this.noteService.deleteNote(position);
        }
      }, 
      {
        text: 'Edit',
        icon: 'create',
        handler: () => {
          const note = this.noteService.updateNote(position);
          this.title = note.title;
          this.text = note.text;
        }
      }
      ,{
        text: 'Cancel',
        icon: 'close',
        role: 'cancel',
        handler: () => {
          // Nothing to do, action sheet will automatically closed
        }
      }]
    });
    await actionSheet.present();
  }
}
