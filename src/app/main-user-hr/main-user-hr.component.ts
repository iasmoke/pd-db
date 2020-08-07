import { Component, OnInit, ViewChild } from '@angular/core';
import { MatTableDataSource } from '@angular/material/table';
import { FormGroup, FormBuilder, Validators, FormControl, } from '@angular/forms';
import { MatSort } from '@angular/material/sort';
import { MatPaginator } from '@angular/material/paginator';
import { MainService } from '../service/main.service';
import { LoginService } from '../service/login.service';
import * as moment from 'moment';
import { Observable, } from 'rxjs';
import { DateAdapter, MAT_DATE_FORMATS, MAT_DATE_LOCALE } from '@angular/material/core';
import { MAT_MOMENT_DATE_ADAPTER_OPTIONS, MAT_MOMENT_DATE_FORMATS, MomentDateAdapter } from '@angular/material-moment-adapter';
moment.locale('ru');
declare var $: any;


@Component({
  selector: 'app-main-user-hr',
  templateUrl: './main-user-hr.component.html',
  styleUrls: ['./main-user-hr.component.scss'],
  providers: [
    {
      provide: MAT_DATE_LOCALE,
      useValue: 'ru-RU'
    },
    {
      provide: DateAdapter,
      useClass: MomentDateAdapter,
      deps: [MAT_DATE_LOCALE, MAT_MOMENT_DATE_ADAPTER_OPTIONS]
    },
    { provide: MAT_DATE_FORMATS, useValue: MAT_MOMENT_DATE_FORMATS },
  ],
})

export class MainUserHrComponent implements OnInit {

  id_tt: string[];
  filteredOptions: Observable<string[]>;
  myControl = new FormControl();

  colors = {red:'#ef5350',grean:'#b2fab4', gray:'#9e9e9e'}

  office = true;
  trade_dot = false;
  if_rejection_reasos = false;
  internships = false;
  candidat = false;

  dataTable_user_hr = [];
  displayedColumns_user_hr: string[] = [
    'id_personal',
    'fio',
    'position',
    'interview_date',
    'department',
    'number_phone',
    'internship_date',
    'internship_place',
    'rejection_reason',
    'status'
  ];
  dataSource = new MatTableDataSource();

  new_form_employee: FormGroup;
  form_edit_employee: FormGroup;
  interview_date:any
  internship_date:any

  alert_message: any;

  array_data_employee = null;
  modal_alert_message: any;
  user_name_create_employee = this.loginService.user_name;

  id_personal: any;

  @ViewChild(MatSort, { static: false }) sort: MatSort;
  @ViewChild(MatPaginator, { static: true }) paginator: MatPaginator;

  constructor(
    private mainService: MainService,
    private formBuilder: FormBuilder,
    public loginService: LoginService
  ) {
    this.mainService.get_table_main_user_hr(this.user_name_create_employee).subscribe((res) => {
      this.dataTable_user_hr = JSON.parse(res);
      this.dataSource = new MatTableDataSource(this.dataTable_user_hr);
      this.dataSource.sort = this.sort;
      this.dataSource.paginator = this.paginator;
      this.new_form_employee.get('attraction_channel_description').disable();
    });

    this.mainService.get_id_tt().subscribe(res => {
      this.id_tt = JSON.parse(res)
      console.log(this.id_tt);
    })
  }

  get_table_personal() {
    this.mainService.get_table_main_user_hr(this.user_name_create_employee).subscribe((res) => {
      this.dataTable_user_hr = JSON.parse(res);
      this.dataSource = new MatTableDataSource(this.dataTable_user_hr);
      this.dataSource.sort = this.sort;
      this.dataSource.paginator = this.paginator;
    });
  }

  get_id_tt() {
    this.mainService.get_id_tt().subscribe(res => {
      this.id_tt = JSON.parse(res)
      console.log(this.id_tt);
    })
  }


  add_employee() {
    if (this.new_form_employee.invalid) {
      console.log(this.new_form_employee);
      return console.log('new_form_employee.invalid');
    }
    let date_now = moment(new Date()).format('YYYY-MM-DD HH:mm:ss');
    let date_interview = moment(this.new_form_employee.value.date_interview).format('YYYY-MM-DD');
    this.new_form_employee.controls['interview_date'].setValue(date_interview);
    this.mainService.user_hr_add_employee(this.new_form_employee.value, date_now, this.user_name_create_employee).subscribe((res) => {
      console.log(res);
      console.log(this.new_form_employee);
      this.alert_message = JSON.parse(res);
      if (this.alert_message === 'Пользователь добавлен') {
        this.get_table_personal();
        $('#modalNew_user').modal('hide');
        $('#modalAddEmloyee').modal('show');
        setTimeout(function () {
          $('#modalAddEmloyee').modal('hide');
        }, 2000);
        this.new_form_employee.reset();
      } else {
        $('#modalNew_user').modal('hide');
        $('#modal_alert_add_error').modal('show');
        setTimeout(function () {
          $('#modal_alert_add_error').modal('hide');
        }, 2000);
      }
    });
  }

  open_edit_employee(row) {
    $('#modal_edit_employee').modal({
      backdrop: 'static',
      show: true,
    });
    console.log(row);
    this.id_personal = row.id_personal;
    let array_row = row.fio.split(' ')
    this.form_edit_employee.controls['first_name'].setValue(array_row[0]);
    this.form_edit_employee.controls['last_name'].setValue(array_row[1]);
    this.form_edit_employee.controls['second_name'].setValue(array_row[2]);
    this.form_edit_employee.controls['position'].setValue(row.position);
    this.form_edit_employee.controls['department'].setValue(row.department);
    this.form_edit_employee.controls['number_phone'].setValue(row.number_phone.substr(3));
    this.form_edit_employee.controls['attraction_channel'].setValue(row.attraction_channel);
    this.form_edit_employee.controls['type_department'].setValue(row.type_department);
    this.form_edit_employee.controls['attraction_channel_description'].setValue(row.attraction_channel_description);
    this.form_edit_employee.controls['interview_date'].setValue(row.interview_date);
    this.form_edit_employee.controls['internship_date'].setValue(row.internship_date);
    this.form_edit_employee.controls['certification_date'].setValue(row.certification_date);
    this.form_edit_employee.controls['internship_place'].setValue(row.internship_place);
    this.form_edit_employee.controls['rejection_reason'].setValue(row.rejection_reason);
    this.form_edit_employee.controls['status'].setValue(row.status);
    this.form_edit_employee.controls['employee_description'].setValue(row.employee_description);
  }

  update_employee() {
   
    if (this.form_edit_employee.invalid) {
      console.log('false');
      console.log(this.form_edit_employee)

    } else {
      let date_now = moment(new Date()).format('YYYY-MM-DD HH:mm:ss');
      this.form_edit_employee.get('interview_date').setValue(moment(this.form_edit_employee.value.interview_date).format("YYYY-MM-DD"))
      this.form_edit_employee.get('internship_date').setValue(moment(this.form_edit_employee.value.internship_date).format("YYYY-MM-DD"))
      this.form_edit_employee.get('certification_date').setValue(moment(this.form_edit_employee.value.certification_date).format("YYYY-MM-DD"))
      console.log(this.form_edit_employee);
      
      this.mainService.user_hr_update_employee(this.loginService.user_name,this.form_edit_employee.value,this.id_personal,date_now)
        .subscribe((res) => {
          console.log(res)
          this.modal_alert_message = JSON.parse(res);
          if (this.modal_alert_message === 'Данные обновлены') {
            this.get_table_personal();
            $('#modal_edit_employee').modal('hide');
            $('#modal_alert_edit_employee').modal('show');
            setTimeout(function () {
              $('#modal_alert_edit_employee').modal('hide');
            }, 2000);
          } else if (this.modal_alert_message === 'Error') {
            $('#modal_edit_employee').modal('hide');
            $('#modal_alert_edit_error').modal('show');
            setTimeout(function () {
              $('#modal_alert_edit_error').modal('hide');
            }, 2000);
          }

        });
    }

  }

  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.dataSource.filter = filterValue.trim().toLowerCase();
  }

  onChangesAddForm() {
    this.new_form_employee
      .get('attraction_channel')
      .valueChanges.subscribe((selectAttraction_channel) => {
        if (selectAttraction_channel === 'Рекомендация от третих лиц') {
          this.new_form_employee.get('attraction_channel_description').enable();
        } else {
          this.new_form_employee.get('attraction_channel_description').reset();
          this.new_form_employee.get('attraction_channel_description').disable();
        }
      });
  }


  onChangesPosition() {
    this.new_form_employee.get('type_department').valueChanges.subscribe((selectType_department) => {
      if (selectType_department === 'Офис') {
        this.office = true;
        this.trade_dot = false
      } else {
        this.office = false;
        this.trade_dot = true
      }
    });
    this.form_edit_employee.get('type_department').valueChanges.subscribe((selectType_department) => {
      if (selectType_department === 'Офис') {
        this.office = true;
        this.trade_dot = false
      } else {
        this.office = false;
        this.trade_dot = true
      }
    });
  }

  onChangesRejection() {
    this.form_edit_employee.get('status').valueChanges.subscribe((select_status) => {
      if (select_status === 'Отказ') {
        this.if_rejection_reasos = true
      } else {
        this.if_rejection_reasos = false;
        this.form_edit_employee.get('rejection_reason').setValue('-')
      }
    })
  }

  onChangesEditForm() {
    this.form_edit_employee.get('attraction_channel').valueChanges.subscribe((selectAttraction_channel) => {
      if (selectAttraction_channel === 'Рекомендация от третих лиц') {
        this.form_edit_employee.get('attraction_channel_description').enable();
      } else {
        this.form_edit_employee.get('attraction_channel_description').reset();
        this.form_edit_employee.get('attraction_channel_description').disable();
      }
    });
  }

  onChangesStatus() {
    this.new_form_employee.get('status').valueChanges.subscribe((status) => {
      if (status === 'Кандидат') {
       this.candidat = true
      } else {
        this.candidat = false
      }
    });
    this.form_edit_employee.get('status').valueChanges.subscribe((selectStatus) => {
      if (selectStatus === 'Стажёр') {
        this.internships = true
      } else {
        this.internships = false

      }
    });
  }

  private _filter(value: string): string[] {
    const filterValue = value.toLowerCase();

    return this.id_tt.filter(option => option.toLowerCase().indexOf(filterValue) === 0);
  }

  ngOnInit(): void {

    this.form_edit_employee = this.formBuilder.group({
      first_name: ['', [Validators.required]],
      last_name: ['', [Validators.required]],
      second_name: ['', [Validators.required]],
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
    });

    this.new_form_employee = this.formBuilder.group({
      first_name: new FormControl('', Validators.required),
      last_name: new FormControl('', Validators.required),
      second_name: new FormControl('', Validators.required),
      number_phone: new FormControl('', [Validators.required, Validators.pattern('[0-9]{10}')]),
      type_department: new FormControl('', Validators.required),
      position: new FormControl('', Validators.required),
      department: new FormControl('', Validators.required),
      attraction_channel: new FormControl(''),
      attraction_channel_description: new FormControl(''),
      interview_date: new FormControl(''),
      status: new FormControl('', Validators.required),
    });
    this.onChangesAddForm();
    this.onChangesEditForm();
    this.onChangesPosition();
    this.onChangesRejection();
    this.onChangesStatus();
  }

  get f() {
    return this.new_form_employee.controls;
  }

  get form_edit() {
    return this.form_edit_employee.controls;
  }


}
