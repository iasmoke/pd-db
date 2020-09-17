import { Component, Inject, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { MatSnackBar } from '@angular/material/snack-bar';
import { DialogData } from '../main/main.component';
import { MainService } from '../service/main.service';
import * as moment from 'moment';

@Component({
  templateUrl: './modal-hr.component.html',
  styleUrls: ['./modal-hr.component.scss']
})
export class ModalHrComponent implements OnInit {

  newPerson: FormGroup;
  editPerson: FormGroup;

  user_name = this.data.user_name
  modal_alert_message: any
  office = true;
  trade_dot = false
  formValueAdd = this.data.value === 'new' ? true : false;
  formValueEdit = this.data.value === 'edit' ? true : false;
  id_tt: any
  candidate = false
  internships = false
  if_rejection_reasons = false

  constructor(
    public dialogRef: MatDialogRef<ModalHrComponent>,
    @Inject(MAT_DIALOG_DATA) public data: DialogData,
    public formBuilder: FormBuilder,
    private mainService: MainService,
    private _snackBar: MatSnackBar
  ) {
    this.mainService.get_id_tt().subscribe(res => {
      this.id_tt = JSON.parse(res)
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
          number_phone: new FormControl('', [Validators.required, Validators.pattern('[0-9]{10}')]),
          type_department: new FormControl('', Validators.required),
          position: new FormControl('', Validators.required),
          department: new FormControl('', Validators.required),
          attraction_channel: new FormControl(''),
          attraction_channel_description: new FormControl(''),
          interview_date: new FormControl(''),
          status: new FormControl('', Validators.required),
          color: new FormControl('')
        });
        break;
      case 'edit':
        this.editPerson = this.formBuilder.group({
          first_name: ['', [Validators.required]],
          last_name: ['', [Validators.required]],
          second_name: new FormControl(''),
          position: ['', [Validators.required]],
          department: ['', [Validators.required]],
          number_phone: ['', [Validators.required, Validators.pattern('[0-9]{10}')],],
          attraction_channel: [''],
          type_department: ['', [Validators.required]],
          attraction_channel_description: [''],
          interview_date: [''],
          internship_date: [''],
          internship_place: [''],
          certification_date: [''],
          rejection_reason: [''],
          status: ['', [Validators.required]],
          employee_description: [''],
          color: new FormControl('')
        });

        let array_row = this.data.row.fio.split(' ')
        this.editPerson.controls['first_name'].setValue(array_row[0]);
        this.editPerson.controls['last_name'].setValue(array_row[1]);
        this.editPerson.controls['second_name'].setValue(array_row[2]);
        this.editPerson.controls['position'].setValue(this.data.row.position);
        this.editPerson.controls['department'].setValue(this.data.row.department);
        this.editPerson.controls['number_phone'].setValue(this.data.row.number_phone.substr(3));
        this.editPerson.controls['attraction_channel'].setValue(this.data.row.attraction_channel);
        this.editPerson.controls['type_department'].setValue(this.data.row.type_department);
        this.editPerson.controls['attraction_channel_description'].setValue(this.data.row.attraction_channel_description);
        this.editPerson.controls['interview_date'].setValue(moment.parseZone(this.data.row.interview_date, "DD-MM-YYYY"));
        this.editPerson.controls['internship_date'].setValue(moment.parseZone(this.data.row.internship_date, "DD-MM-YYYY"));
        this.editPerson.controls['certification_date'].setValue(moment.parseZone(this.data.row.certification_date, "DD-MM-YYYY"));
        this.editPerson.controls['internship_place'].setValue(this.data.row.internship_place);
        this.editPerson.controls['rejection_reason'].setValue(this.data.row.rejection_reason);
        this.editPerson.controls['status'].setValue(this.data.row.status);
        this.editPerson.controls['employee_description'].setValue(this.data.row.employee_description);
        this.editPerson.controls['color'].setValue(this.data.row.color);
        break;
    }
    this.onChangesEditForm();
    this.onChangesPosition();
    this.onChangesRejection();
    this.onChangesStatus();
  }

  add_employee() {
    switch (this.newPerson.invalid) {
      case true:
        console.log(this.newPerson);
        break;
      default:
        let date_now = moment(new Date()).format('DD.MM.YYYY HH:mm:ss');
        this.mainService.user_hr_add_employee(this.newPerson.value, date_now, this.user_name).subscribe((res) => {
          this.modal_alert_message = JSON.parse(res);
          console.log(this.modal_alert_message);
          switch (this.modal_alert_message) {
            case 'Пользователь добавлен':
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





  update_employee() {
    if (this.editPerson.invalid) {
      console.log(this.editPerson)

    } else {
      let date_now = moment(new Date()).format('DD.MM.YYYY HH:mm:ss');
      this.editPerson.controls['interview_date'].setValue(moment.parseZone(this.editPerson.value.interview_date).format("DD.MM.YYYY"))
      this.editPerson.controls['internship_date'].setValue(moment.parseZone(this.editPerson.value.internship_date).format("DD.MM.YYYY"))
      this.editPerson.controls['certification_date'].setValue(moment.parseZone(this.editPerson.value.certification_date).format("DD.MM.YYYY"))
      console.log(this.editPerson);

      this.mainService.user_hr_update_employee(this.user_name, this.editPerson.value, this.data.row.id_personal, date_now)
        .subscribe((res) => {
          console.log(res)
          this.modal_alert_message = JSON.parse(res);
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
        });
    }

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

  onChangesRejection() {
    switch (this.data.value) {
      case 'edit':
        this.editPerson.get('status').valueChanges.subscribe((select_status) => {
          if (select_status === 'Отказали') {
            this.if_rejection_reasons = true
          } else {
            this.if_rejection_reasons = false;
            this.editPerson.get('rejection_reason').setValue('')
          }
        })
        break;
    }
  }

  onChangesEditForm() {
    switch (this.data.value) {
      case 'edit':
        this.editPerson.get('attraction_channel').valueChanges.subscribe((selectAttraction_channel) => {
          if (selectAttraction_channel === 'Рекомендация от третьих лиц') {
            this.editPerson.get('attraction_channel_description').enable();
          } else {
            this.editPerson.get('attraction_channel_description').reset();
            this.editPerson.get('attraction_channel_description').disable();
          }
        });
        break;
      case 'new':
        this.newPerson.get('attraction_channel').valueChanges.subscribe((selectAttraction_channel) => {
          if (selectAttraction_channel === 'Рекомендация от третьих лиц') {
            this.newPerson.get('attraction_channel_description').enable();
          } else {
            this.newPerson.get('attraction_channel_description').reset();
            this.newPerson.get('attraction_channel_description').disable();
          }
        });
        break;
    }
  }

  onChangesStatus() {
    switch(this.data.value){
      case 'new':
    this.newPerson.get('status').valueChanges.subscribe((status) => {
      if (status === 'Кандидат') {
        this.candidate = true
      } else {
        this.candidate = false
      }
    });
    this.newPerson.get('status').valueChanges.subscribe((selectStatus) => {
      if (selectStatus === 'Стажёр') {
        this.internships = true
      } else {
        this.internships = false

      }
    });
    break;
  }
  }
}
