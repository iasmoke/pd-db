import { Component, OnInit, ViewChild } from '@angular/core';
import { MatSort } from '@angular/material/sort';
import { MatTableDataSource } from '@angular/material/table';
import { MainService } from '../service/main.service';
import { FormGroup, FormBuilder, Validators, FormControl } from '@angular/forms';
import { MatPaginator } from '@angular/material/paginator';
import { LoginService } from '../service/login.service';
import * as moment from 'moment';
import { MAT_DATE_LOCALE, DateAdapter, MAT_DATE_FORMATS } from '@angular/material/core';
import { MomentDateAdapter, MAT_MOMENT_DATE_ADAPTER_OPTIONS, MAT_MOMENT_DATE_FORMATS } from '@angular/material-moment-adapter';
moment.locale('ru')
declare var $: any;



@Component({
  selector: 'app-main',
  templateUrl: './main.component.html',
  styleUrls: ['./main.component.scss'],
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

export class MainComponent implements OnInit {

  dataTable = [];
  displayedColumns: string[] = [
    'id_personal',
    'first_name',
    'last_name',
    'second_name',
    'department',
    'position',
    'number_phone',
    'certification_date',
    'status',
    'employee_description',
    'delete'
  ];
  dataSource = new MatTableDataSource(this.dataTable);

  new_form: FormGroup;
  edit_form: FormGroup;

  office = true;
  trade_dot = false
  search: any

  id_tt: string[];

  row_first_name: any
  row_last_name: any
  row_pesonal_id: any

  array_data_employee = null
  modal_alert_message: any
  user_name_create_employee = this.loginService.user_name

  id_personal: any

  @ViewChild(MatSort, { static: false }) sort: MatSort;
  @ViewChild(MatPaginator, { static: true }) paginator: MatPaginator;

  constructor(
    private mainService: MainService,
    private formBuilder: FormBuilder,
    public loginService: LoginService,
  ) {
    this.mainService.get_table_main().subscribe(res => {
      this.dataTable = JSON.parse(res)
      this.dataSource = new MatTableDataSource(this.dataTable);
      this.dataSource.sort = this.sort;
      this.dataSource.paginator = this.paginator;
      console.log(this.dataTable);
    })

    this.mainService.get_id_tt().subscribe(res => {
      this.id_tt = JSON.parse(res)
      console.log(this.id_tt);
    })

  }

  get_id_tt() {
    this.mainService.get_id_tt().subscribe(res => {
      this.id_tt = JSON.parse(res)
      console.log(this.id_tt);
    })
  }

  get_table_personal() {
    this.mainService.get_table_main().subscribe(res => {
      this.dataTable = JSON.parse(res)
      this.dataSource = new MatTableDataSource(this.dataTable);
      this.dataSource.sort = this.sort;
      this.dataSource.paginator = this.paginator;
      console.log(this.dataTable);
    })
  }

  add_employee() {
    if (this.new_form.invalid) {
      console.log(this.new_form);
      return console.log(this.new_form.invalid);
    }
    let date_now = moment(new Date()).format('DD.MM.YYYY HH:mm:ss');
    this.mainService.add_employee(this.new_form.value, date_now, this.user_name_create_employee).subscribe((res) => {
      console.log(res);
      console.log(this.new_form);
      this.modal_alert_message = JSON.parse(res);
      this.get_table_personal();
      if (this.modal_alert_message === 'Пользователь добавлен') {
        $('#modalNew_user').modal('hide');
        $('#modal_alert_success').modal('show');
        setTimeout(function () {
          $('#modal_alert_success').modal('hide');
        }, 2000);
        this.new_form.reset();
      } else {
        $('#modalNew_user').modal('hide');
        $('#modal_alert_error').modal('show');
        setTimeout(function () {
          $('#modal_alert_error').modal('hide');
        }, 5000);
        console.log(Error);
      }
    });
  }

  open_delete_modal(row) {
    $("#modal_delete_employee").modal('show');
    this.row_first_name = row.first_name
    this.row_last_name = row.last_name
    this.row_pesonal_id = row.id_personal
  }

  delete_employee() {
    this.mainService.main_delete_employee(this.row_pesonal_id).subscribe(res => {
      this.modal_alert_message = JSON.parse(res);
      console.log(this.modal_alert_message);
      if (this.modal_alert_message === 'Пользователь удален') {
        this.get_table_personal();
        $('#modal_delete_employee').modal('hide');
        $('#modal_alert_success').modal('show');
        setTimeout(function () {
          $('#modal_alert_success').modal('hide');
        }, 2000);
      } else {
        $('#modal_edit_employee').modal('hide');
        $('#modal_alert_error').modal('show');
        setTimeout(function () {
          $('#modal_alert_error').modal('hide');
        }, 2000);
      }

    })
  }

  open_edit_employee(row) {
    $("#modal_edit_employee").modal('show');
    console.log(row);
    this.id_personal = row.id_personal;
    this.edit_form.controls['first_name'].setValue(row.first_name);
    this.edit_form.controls['last_name'].setValue(row.last_name);
    this.edit_form.controls['second_name'].setValue(row.second_name);
    this.edit_form.controls['type_department'].setValue(row.type_department);
    this.edit_form.controls['department'].setValue(row.department);
    this.edit_form.controls['position'].setValue(row.position);
    this.edit_form.controls['number_phone'].setValue(row.number_phone.substr(3));
    this.edit_form.controls['status'].setValue(row.status);
    this.edit_form.controls['employee_description'].setValue(row.employee_description);
  }

  update_employee() {
    if (this.edit_form.invalid) {
      console.log('false');
    } else {
      console.log(this.edit_form)
      let date_now = moment(new Date()).format('DD.MM.YYYY HH:mm:ss');
      this.mainService.update_employee(this.loginService.user_name, this.edit_form.value, this.id_personal, date_now).subscribe((res) => {
        this.modal_alert_message = JSON.parse(res);
        console.log(this.modal_alert_message)
        if (this.modal_alert_message === 'Данные обновлены') {
          this.get_table_personal();
          $('#modal_edit_employee').modal('hide');
          $('#modal_alert_success').modal('show');
          setTimeout(function () {
            $('#modal_alert_success').modal('hide');
          }, 2000);
          this.search = ''
        } else if (this.modal_alert_message === 'Error') {
          $('#modal_edit_employee').modal('hide');
          $('#modal_alert_error').modal('show');
          setTimeout(function () {
            $('#modal_alert_error').modal('hide');
          }, 2000);
        }
      });
    }
  }

  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.dataSource.filter = filterValue.trim().toLowerCase();
  }

  onChangesPosition() {
    this.new_form.get('type_department').valueChanges.subscribe((selectType_department) => {
      if (selectType_department === 'Офис') {
        this.office = true;
        this.trade_dot = false
      } else {
        this.office = false;
        this.trade_dot = true
      }
    });
    this.edit_form.get('type_department').valueChanges.subscribe((selectType_department) => {
      if (selectType_department === 'Офис') {
        this.office = true;
        this.trade_dot = false
      } else {
        this.office = false;
        this.trade_dot = true
      }
    });
  }

  ngOnInit(): void {

    this.edit_form = this.formBuilder.group({
      first_name: ['', Validators.required],
      last_name: ['', Validators.required],
      second_name: new FormControl(''),
      department: ['', Validators.required],
      position: ['', Validators.required],
      type_department: ['', Validators.required],
      number_phone: ['', [Validators.required, Validators.pattern("[0-9]{10}")]],
      status: ['', [Validators.required]],
      employee_description: [''],
    });

    this.new_form = this.formBuilder.group({
      first_name: ['', Validators.required],
      last_name: ['', Validators.required],
      second_name: new FormControl(''),
      type_department: ['', Validators.required],
      department: ['', Validators.required],
      position: ['', Validators.required],
      number_phone: ['', [Validators.required, Validators.pattern("[0-9]{10}")]],
      status: ['', [Validators.required]],
      employee_description: [''],
    });

    this.onChangesPosition()
  }

  get fn() { return this.new_form.controls; }

  get fe() { return this.edit_form.controls; }

}
