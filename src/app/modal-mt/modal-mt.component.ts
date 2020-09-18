import { JsonPipe } from '@angular/common';
import { Component, Inject, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { MatSnackBar } from '@angular/material/snack-bar';
import * as moment from 'moment';
import { DialogData } from '../main/main.component';
import { MainService } from '../service/main.service';

@Component({
  selector: 'app-modal-mt',
  templateUrl: './modal-mt.component.html',
  styleUrls: ['./modal-mt.component.scss']
})
export class ModalMtComponent implements OnInit {

  formValueAdd = this.data.value === 'new' ? true : false;

  newTest: FormGroup;
  modal_alert_message: any
  list_position:any

  constructor(
    public dialogRef: MatDialogRef<ModalMtComponent>,
    @Inject(MAT_DIALOG_DATA) public data: DialogData,
    public formBuilder: FormBuilder,
    private mainService: MainService,
    private _snackBar: MatSnackBar
  ) {
    this.mainService.tests_get_list_position().subscribe(res => {
      this.list_position = JSON.parse(res);

    })

   }

  get fn() {
    switch (this.data.value) {
      case 'new':
        return this.newTest.controls;
    }
  }

  ngOnInit(): void {
    switch (this.data.value) {
      case 'new':
        this.newTest = this.formBuilder.group({
          name_test: new FormControl('', Validators.required),
          description_test: new FormControl(''),
          max_score: new FormControl('', [Validators.pattern('[0-9]'), Validators.max(200), Validators.required]),
          position_type: new FormControl('', Validators.required),
        });
        break;
    }
  }

  addNewTest() {
    this.mainService.tests_add_new_test(this.newTest.value).subscribe(res => {
      this.modal_alert_message = JSON.parse(res)
      switch (this.modal_alert_message) {
        case 'Новый тест добавлен':
          this.dialogRef.close(this.modal_alert_message)
          break;
        default:
          this._snackBar.open(this.modal_alert_message[0].error, '', {
            duration: 7000,
            horizontalPosition: 'center',
            verticalPosition: 'top',
            panelClass: 'alert-style-error'
          });
          break

      }
    })
  }

}
