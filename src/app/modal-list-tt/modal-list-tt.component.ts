import { Component, Inject, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup } from '@angular/forms';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { MatSnackBar } from '@angular/material/snack-bar';
import { DialogData } from '../main/main.component';
import { ListTtService } from '../service/list-tt.service';
import * as moment from 'moment';


@Component({
  templateUrl: './modal-list-tt.component.html',
  styleUrls: ['./modal-list-tt.component.scss']
})
export class ModalListTtComponent implements OnInit {

  new_outlet: FormGroup;
  edit_outlet: FormGroup;

  modal_alert_message: any;

  formValueAdd = this.data.value === 'new' ? true : false;
  formValueEdit = this.data.value === 'edit' ? true : false;

  constructor(
    public dialogRef: MatDialogRef<ModalListTtComponent>,
    @Inject(MAT_DIALOG_DATA) public data: DialogData,
    public formBuilder: FormBuilder,
    private ListTtService: ListTtService,
    private _snackBar: MatSnackBar
      ) {

  }

  ngOnInit(): void {
    switch (this.data.value) {
      case 'new':
    this.new_outlet = this.formBuilder.group({
      number_td: new FormControl(),
      address: new FormControl(),
      city: new FormControl(),
      date_open: new FormControl(),
      manager: new FormControl(),
      rm: new FormControl(),
    });
      break;
      case 'edit':
    this.edit_outlet = this.formBuilder.group({
      id_tt: new FormControl(),
      number_td: new FormControl(),
      address: new FormControl(),
      city: new FormControl(),
      date_open: new FormControl(),
      manager: new FormControl(),
      rm: new FormControl()
    });
        this.edit_outlet.controls['id_tt'].setValue(this.data.row.id_tt)
        this.edit_outlet.controls['number_td'].setValue(this.data.row.number_td);
        this.edit_outlet.controls['address'].setValue(this.data.row.address);
        this.edit_outlet.controls['date_open'].setValue(moment.parseZone(this.data.row.date_open,"DD-MM-YYYY"));
        this.edit_outlet.controls['city'].setValue(this.data.row.city);
        this.edit_outlet.controls['manager'].setValue(this.data.row.manager);
        this.edit_outlet.controls['rm'].setValue(this.data.row.rm);
        console.log(this.edit_outlet);
        
    break;
  }
  }

  addOutlet() {
    switch (this.new_outlet.invalid) {
      case true:
        console.log(this.new_outlet.value);
        break;
      default:
        this.ListTtService.add_outlet(this.new_outlet.value).subscribe((res) => {
          console.log(this.new_outlet.value);
          this.modal_alert_message = JSON.parse(res);
          switch (this.modal_alert_message) {
            case 'Торговая точка добавлена':
              this.dialogRef.close(this.modal_alert_message)
              break;
            default:
              this._snackBar.open(this.modal_alert_message, '', {
                duration: 7000,
                horizontalPosition: 'center',
                verticalPosition: 'top',
                panelClass: 'alert-style-error'
              });
              break;
          }
        });
    }
  }

  editOutlet() {
    switch (this.edit_outlet.invalid) {
      case true:
        console.log(this.edit_outlet.value);
        break;
      default:
        this.ListTtService.edit_outlet(this.edit_outlet.value).subscribe((res) => {
          this.modal_alert_message = JSON.parse(res);
          console.log(this.modal_alert_message)
          switch (this.modal_alert_message) {
            case 'Данные обновлены':
              this.dialogRef.close(this.modal_alert_message)
              break;
            default:
              this._snackBar.open(this.modal_alert_message, '', {
                duration: 7000,
                horizontalPosition: 'center',
                verticalPosition: 'top',
                panelClass: 'alert-style-error'
              });
              break;
          }
        })
    }
  }
}
