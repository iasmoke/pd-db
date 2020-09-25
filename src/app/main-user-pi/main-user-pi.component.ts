import { Component, OnInit, ViewChild } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { MatPaginator } from '@angular/material/paginator';
import { MatSort } from '@angular/material/sort';
import { MatTableDataSource } from '@angular/material/table';
import { LoginService } from '../service/login.service';
import { MainService } from '../service/main.service';
import * as moment from 'moment';
import { MAT_DATE_LOCALE, DateAdapter, MAT_DATE_FORMATS } from '@angular/material/core';
import { MomentDateAdapter, MAT_MOMENT_DATE_ADAPTER_OPTIONS, MAT_MOMENT_DATE_FORMATS } from '@angular/material-moment-adapter';
moment.locale('ru');
declare var $: any;

@Component({
  selector: 'app-main-user-pi',
  templateUrl: './main-user-pi.component.html',
  styleUrls: ['./main-user-pi.component.scss'],
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
export class MainUserPiComponent implements OnInit {

  form_edit_employee: FormGroup;
  search: any;
  office = false;
  trade_dot = true;
  if_dismissal = false;

  alert_message: any;
  array_data_employee = null;
  modal_alert_message: any;

  user_name_create_employee = this.loginService.user_name;
  date_dismissal:any
  date_birth:any

  id_person: any;

  id_tt: string[];
  dataTable_user_pi = [];
  displayedColumns_user_hr: string[] = [
    'id_person', 'first_name', 'last_name', 'second_name',
    'position', 'department', 'number_phone',
    'date_birth', 'date_forming', 'place_residence', 'city_residence', 'available_doc',
    `date_dismissal`, 'inn', 'status'
  ];
  dataSource = new MatTableDataSource();

  @ViewChild(MatSort, { static: false }) sort: MatSort;
  @ViewChild(MatPaginator, { static: true }) paginator: MatPaginator;

  constructor(
    private mainService: MainService,
    private formBuilder: FormBuilder,
    public loginService: LoginService
  ) {
    this.mainService.user_pi_get_table_main().subscribe(res => {
      this.dataTable_user_pi = JSON.parse(res);
      this.dataSource = new MatTableDataSource(this.dataTable_user_pi);
      this.dataSource.sort = this.sort;
      this.dataSource.paginator = this.paginator;

    })

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
      date_birth: [''],
      position: [''],
      type_department: ['', [Validators.required]],
      department: ['', [Validators.required]],
      available_doc: ['', [Validators.required]],
      number_phone: ['', [Validators.required]],
      city_registration: [''],
      address_registration: [''],
      city_residence: [''],
      place_residence: [''],
      status: ['', [Validators.required]],
      date_dismissal: [''],
      description_dismissal: [''],
      inn: [''],
    });

    this.onChangesPosition();
    this.onChangesDismissal();
  }

  open_edit_employee(row) {
    $('#modal_edit_employee').modal({
      backdrop: 'static',
      show: true,
    });
    console.log(row);
    this.id_person = row.id_person;
    this.form_edit_employee.controls['first_name'].setValue(row.first_name);
    this.form_edit_employee.controls['last_name'].setValue(row.last_name);
    this.form_edit_employee.controls['second_name'].setValue(row.second_name);
    this.form_edit_employee.controls['position'].setValue(row.position);
    this.form_edit_employee.controls['department'].setValue(row.department);
    this.form_edit_employee.controls['number_phone'].setValue(row.number_phone.substr(1));
    this.form_edit_employee.controls['date_birth'].setValue(row.date_birth);
    this.form_edit_employee.controls['type_department'].setValue(row.type_department);
    this.form_edit_employee.controls['available_doc'].setValue(row.available_doc);
    this.form_edit_employee.controls['city_registration'].setValue(row.city_registration);
    this.form_edit_employee.controls['address_registration'].setValue(row.address_registration);
    this.form_edit_employee.controls['city_residence'].setValue(row.city_residence);
    this.form_edit_employee.controls['place_residence'].setValue(row.place_residence);
    this.form_edit_employee.controls['status'].setValue(row.status);
    this.form_edit_employee.controls['date_dismissal'].setValue(row.date_dismissal);
    this.form_edit_employee.controls['description_dismissal'].setValue(row.description_dismissal);
    this.form_edit_employee.controls['inn'].setValue(row.inn);
  }

  get_table_personal() {
    this.mainService.user_pi_get_table_main().subscribe((res) => {
      this.dataTable_user_pi = JSON.parse(res);
      this.dataSource = new MatTableDataSource(this.dataTable_user_pi);
      this.dataSource.sort = this.sort;
      this.dataSource.paginator = this.paginator;
    });
  }

  update_employee() {
    if (this.form_edit_employee.invalid) {
      console.log('false');
    } else {
      let date_now = moment(new Date()).format('DD.MM.YYYY HH:mm:ss');
      this.form_edit_employee.get('date_dismissal').setValue(moment(this.form_edit_employee.value.date_dismissal).format("YYYY-MM-DD"));
      this.form_edit_employee.get('date_birth').setValue(moment(this.form_edit_employee.value.date_birth).format("YYYY-MM-DD"));
      this.mainService.user_pi_update_employee(this.loginService.user_name, this.form_edit_employee.value, this.id_person, date_now)
        .subscribe((res) => {
          this.modal_alert_message = JSON.parse(res);
          console.log( this.modal_alert_message)
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


  onChangesPosition() {
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

  onChangesDismissal() {
    this.form_edit_employee.get('status').valueChanges.subscribe((select_status) => {
      if (select_status === 'Уволенный') {
        this.if_dismissal = true
      } else {
        this.if_dismissal = false;
        this.form_edit_employee.get('date_dismissal').setValue(new Date())
      }
    })
  }

  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.dataSource.filter = filterValue.trim().toLowerCase();
  }

}
