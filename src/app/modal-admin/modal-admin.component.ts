import { Component, Inject, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { DialogData } from '../main/main.component';
import * as moment from 'moment';
import { MainService } from '../service/main.service';
import { MatSnackBar } from '@angular/material/snack-bar';

@Component({
  templateUrl: './modal-admin.component.html',
  styleUrls: ['./modal-admin.component.scss']
})
export class ModalAdminComponent implements OnInit {

  newPerson: FormGroup;
  editPerson: FormGroup;

  user_name = this.data.user_name
  modal_alert_message: any
  office = true;
  trade_dot = false
  formValueAdd = this.data.value === 'new' ? true : false;
  formValueEdit = this.data.value === 'edit' ? true : false;
  valueDelete = this.data.value === 'delete' ? true : false;
  id_tt: any

  first_name:any
  last_name:any




  constructor(
    public dialogRef: MatDialogRef<ModalAdminComponent>,
    @Inject(MAT_DIALOG_DATA) public data: DialogData,
    public formBuilder: FormBuilder,
    private mainService: MainService,
    private _snackBar: MatSnackBar
  ) {

    this.mainService.get_id_tt().subscribe(res => {
      this.id_tt = JSON.parse(res)
      console.log(this.id_tt);
    })
  }



  get fn() {
    switch (this.data.value) {
      case 'new':
        return this.newPerson.controls;
      case 'edit':
        return this.editPerson.controls;
    }
  }



  ngOnInit(): void {
    switch (this.data.value) {
      case 'new':
        this.newPerson = this.formBuilder.group({
          first_name: new FormControl('', Validators.required),
          last_name: new FormControl('', Validators.required),
          second_name: new FormControl(''),
          type_department: new FormControl('', Validators.required),
          department: new FormControl('', Validators.required),
          position: new FormControl('', Validators.required),
          number_phone: new FormControl('', [Validators.required, Validators.pattern("[0-9]{10}")]),
          status: new FormControl('', Validators.required),
          employee_description: [''],
        });
        break;
      case 'edit':
        this.editPerson = this.formBuilder.group({
          first_name: new FormControl('', Validators.required),
          last_name: new FormControl('', Validators.required),
          second_name: new FormControl(''),
          department: new FormControl('', Validators.required),
          position: new FormControl('', Validators.required),
          type_department: new FormControl('', Validators.required),
          number_phone: new FormControl('', [Validators.required, Validators.pattern("[0-9]{10}")]),
          status: new FormControl('', Validators.required),
          employee_description: new FormControl(''),
        });
        let array_row = this.data.row.fio.split(' ')
        this.editPerson.controls['first_name'].setValue(array_row[1]);
        this.editPerson.controls['last_name'].setValue(array_row[0]);
        this.editPerson.controls['second_name'].setValue(array_row[2]);
        this.editPerson.controls['type_department'].setValue(this.data.row.type_department);
        this.editPerson.controls['department'].setValue(this.data.row.department);
        this.editPerson.controls['position'].setValue(this.data.row.position);
        this.editPerson.controls['number_phone'].setValue(this.data.row.number_phone.substr(3));
        this.editPerson.controls['status'].setValue(this.data.row.status);
        this.editPerson.controls['employee_description'].setValue(this.data.row.employee_description);

        this.editPerson.value.type_department === 'Офис' ? this.office = true : false
        this.editPerson.value.type_department === 'Торговая точка' ? this.trade_dot = true : false
        break;
        case 'delete':
          let fio = this.data.row.fio.split(' ')
          this.first_name = fio[1]
          this.last_name = fio[0]
        break;
    }

    this.onChangesPosition()
  }

  add_employee() {
    switch (this.newPerson.invalid) {
      case true:
        console.log(this.newPerson.value);
        break;
      default:
        let dateTimeNow = moment.parseZone(new Date()).format('YYYY-MM-DD HH:mm:ss')
        this.mainService.admin_main_add_employee(this.newPerson.value, dateTimeNow, this.user_name).subscribe((res) => {
          this.modal_alert_message = JSON.parse(res);
          switch (this.modal_alert_message) {
            case 'Пользователь добавлен':
              this.newPerson.reset()
              this.dialogRef.close(this.modal_alert_message)
              break;
            default:
              this._snackBar.open(this.modal_alert_message[0].error, '', {
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


  update_employee() {
    switch (this.editPerson.invalid) {
      case true:
        console.log(this.editPerson.value);
        break;
      default:
        let dateTimeNow = moment.parseZone(new Date()).format('YYYY-MM-DD HH:mm:ss')
        this.mainService.admin_main_update_employee(this.user_name, this.editPerson.value, dateTimeNow).subscribe((res) => {
          this.modal_alert_message = JSON.parse(res);
          console.log(this.modal_alert_message)
          switch (this.modal_alert_message) {
            case 'Данные обновлены':
              this.dialogRef.close(this.modal_alert_message)
              break;
            default:
              this._snackBar.open(this.modal_alert_message[0].error, '', {
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

  delete_employee() {
    this.mainService.admin_main_delete_employee(this.data.row.id_person).subscribe(res => {
      this.modal_alert_message = JSON.parse(res);
      console.log(this.modal_alert_message);
      switch (this.modal_alert_message) {
        case 'Пользователь удален':
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


  onChangesPosition() {
    switch (this.data.value) {
      case 'new':
        this.newPerson.get('type_department').valueChanges.subscribe((selectType_department) => {
          if (selectType_department === 'Офис') {
            this.office = true;
            this.trade_dot = false
          } else {
            this.office = false;
            this.trade_dot = true
          }
        });
        break;
      case 'edit':
        this.editPerson.get('type_department').valueChanges.subscribe((selectType_department) => {
          if (selectType_department === 'Офис') {
            this.office = true;
            this.trade_dot = false
          } else {
            this.office = false;
            this.trade_dot = true
          }
        });
        break;
    }
  }



}
