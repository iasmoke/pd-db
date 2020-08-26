import { Component, OnInit, ViewChild } from '@angular/core';
import { FormControl, FormGroup, FormBuilder, Validators } from '@angular/forms';
import { MatTableDataSource } from '@angular/material/table';
import { MatSort } from '@angular/material/sort';
import { MatPaginator } from '@angular/material/paginator';
import { MainService } from '../service/main.service';
import { LoginService } from '../service/login.service';
declare var $: any;
import * as moment from 'moment';
import { DateAdapter, MAT_DATE_FORMATS, MAT_DATE_LOCALE } from '@angular/material/core';
import { MAT_MOMENT_DATE_ADAPTER_OPTIONS, MAT_MOMENT_DATE_FORMATS, MomentDateAdapter } from '@angular/material-moment-adapter';
moment.locale('uk');


@Component({
  selector: 'app-main-user-mt',
  templateUrl: './main-user-mt.component.html',
  styleUrls: ['./main-user-mt.component.scss'],
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
export class MainUserMtComponent implements OnInit {

  id_tt: string[];
  search: any

  office = true;
  trade_dot = false;
  if_rejection_reasos = false;
  internships = false;

  dataTable_user_mt = [];
  displayedColumns_user_hr: string[] = [
    'id_personal',
    'fio',
    'department',
    'position',
    'certification_date',
    'test_number_ball_1',
    'test_date_1',
    'test_number_ball_2',
    'test_date_2',
    'internship_place',
    'internship_date',
    'status'
  ];
  dataSource = new MatTableDataSource();

  new_form_employee: FormGroup;
  form_edit_employee: FormGroup;

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
    this.mainService.user_mt_get_table_main().subscribe((res) => {
      this.dataTable_user_mt = JSON.parse(res);
      this.dataSource = new MatTableDataSource(this.dataTable_user_mt);
      this.dataSource.sort = this.sort;
      this.dataSource.paginator = this.paginator;
    });

    this.mainService.get_id_tt().subscribe(res => {
      this.id_tt = JSON.parse(res)
    })
  }

  get form_edit() {
    return this.form_edit_employee.controls;
  }

  ngOnInit(): void {
    this.form_edit_employee = this.formBuilder.group({
      first_name: ['', [Validators.required]],
      last_name: ['', [Validators.required]],
      second_name: ['', [Validators.required]],
      test_date_1: new FormControl(''),
      test_number_ball_1: ['', [Validators.min(10), Validators.max(100)]],
      test_date_2: new FormControl(''),
      test_number_ball_2: ['', [Validators.min(10), Validators.max(100)]],
      number_phone: ['', [Validators.required, Validators.pattern('[0-9]{10}')]],
      certification_date: new FormControl(''),
      internship_date: new FormControl(''),
      internship_place: [''],
      status: ['', [Validators.required]],
      employee_description: [''],
    });
  }

  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.dataSource.filter = filterValue.trim().toLowerCase();
  }

  open_edit_employee(row) {
    this.id_personal = row.id_personal;
    let array_row = row.fio.split(' ')
    this.form_edit_employee.controls['first_name'].setValue(array_row[0]);
    this.form_edit_employee.controls['last_name'].setValue(array_row[1]);
    this.form_edit_employee.controls['second_name'].setValue(array_row[2]);
    this.form_edit_employee.controls['number_phone'].setValue(row.number_phone.substr(3));
    this.form_edit_employee.controls['test_number_ball_1'].setValue(row.test_number_ball_1);
    this.form_edit_employee.controls['test_number_ball_2'].setValue(row.test_number_ball_2);
    this.form_edit_employee.controls['internship_place'].setValue(row.internship_place);
    this.form_edit_employee.controls['status'].setValue(row.status);
    this.form_edit_employee.controls['test_date_1'].setValue(row.test_date_1);
    this.form_edit_employee.controls['test_date_2'].setValue(row.test_date_2);
    this.form_edit_employee.controls['certification_date'].setValue(row.certification_date);
    this.form_edit_employee.controls['internship_date'].setValue(row.internship_date);
    this.form_edit_employee.controls['employee_description'].setValue(row.employee_description);
    row.test_date_1 === '' ? this.form_edit_employee.controls['test_date_1'].setValue(row.test_date_1) : this.form_edit_employee.controls['test_date_1'].setValue(moment(row.test_date_1, "DD.MM.YYYY"));
    row.test_date_2 === '' ? this.form_edit_employee.controls['test_date_2'].setValue(row.test_date_2) : this.form_edit_employee.controls['test_date_2'].setValue(moment(row.test_date_2, "DD.MM.YYYY"));
    row.internship_date === '' ? this.form_edit_employee.controls['internship_date'].setValue(row.internship_date) : this.form_edit_employee.controls['internship_date'].setValue(moment(row.internship_date, "DD.MM.YYYY")) ;
    row.certification_date === '' ? this.form_edit_employee.controls['certification_date'].setValue(row.certification_date) : this.form_edit_employee.controls['certification_date'].setValue(moment(row.certification_date, "DD.MM.YYYY"));
    $('#modal_edit_employee').modal({
      backdrop: 'static',
      show: true,
    });
  }

  update_employee() {
    if (this.form_edit_employee.invalid) {
      console.log('false');
    } else {
      let date_now = moment(new Date()).format('DD.MM.YYYY HH:mm:ss');
      this.form_edit_employee.get('test_date_1').setValue(moment(this.form_edit_employee.value.test_date_1).format("DD.MM.YYYY"));
      this.form_edit_employee.get('test_date_2').setValue(moment(this.form_edit_employee.value.test_date_2).format("DD.MM.YYYY"));
      this.form_edit_employee.get('certification_date').setValue(moment(this.form_edit_employee.value.certification_date).format("DD.MM.YYYY"));
      this.form_edit_employee.get('internship_date').setValue(moment(this.form_edit_employee.value.internship_date).format("DD.MM.YYYY"));
      this.mainService.user_mt_update_employee(this.loginService.user_name, this.form_edit_employee.value, this.id_personal, date_now)
        .subscribe((res) => {
          this.modal_alert_message = JSON.parse(res);
          console.log(this.modal_alert_message)
          if (this.modal_alert_message === 'Данные обновлены') {
            this.get_table_personal();
            $('#modal_edit_employee').modal('hide');
            $('#modal_alert_edit_employee').modal('show');
            setTimeout(function () {
              $('#modal_alert_edit_employee').modal('hide');
            }, 2000);
            this.search = ''
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
  get_table_personal() {
    this.mainService.user_mt_get_table_main().subscribe((res) => {
      this.dataTable_user_mt = JSON.parse(res);
      this.dataSource = new MatTableDataSource(this.dataTable_user_mt);
      this.dataSource.sort = this.sort;
      this.dataSource.paginator = this.paginator;
    });
  }

}
