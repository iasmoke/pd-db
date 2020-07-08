import { Component, OnInit, ViewChild } from '@angular/core';
import { Observable } from 'rxjs';
import { FormControl, FormGroup, FormBuilder, Validators } from '@angular/forms';
import { MatTableDataSource } from '@angular/material/table';
import { MatSort } from '@angular/material/sort';
import { MatPaginator } from '@angular/material/paginator';
import { MainService } from '../service/main.service';
import { LoginService } from '../service/login.service';
declare var $: any;
import * as moment from 'moment';
import 'moment/locale/ru';
import { map, startWith, filter } from "rxjs/operators";
import { log } from 'util';
moment.locale('ru');

@Component({
  selector: 'app-main-user-mt',
  templateUrl: './main-user-mt.component.html',
  styleUrls: ['./main-user-mt.component.scss']
})
export class MainUserMtComponent implements OnInit {

  id_tt: string[];


  office = true;
  trade_dot = false;
  if_rejection_reasos = false;
  internships = false;

  dataTable_user_mt = [];
  displayedColumns_user_hr: string[] = [
    'id_personal',
    'first_name',
    'last_name',
    'second_name',
    'position',
    'certification_date',
    'department',
    'number_phone',
    'test_date_1',
    'test_number_ball_1',
    'test_date_2',
    'test_number_ball_2',
    'internship_date',
    'internship_place',
    'status',
    'employee_description'
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
      this.new_form_employee.get('attraction_channel_description').disable();
    });

    this.mainService.get_id_tt().subscribe(res => {
      this.id_tt = JSON.parse(res)
      console.log(this.id_tt);
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
      test_date_1: ['', [Validators.required]],
      test_number_ball_1: ['', [Validators.required]],
      test_date_2: ['', [Validators.required, Validators.pattern('[0-9]{12}')],],
      test_number_ball_2: ['', [Validators.required]],
      number_phone: ['', [Validators.required]],
      certification_date: [''],
      internship_date: ['', [Validators.required]],
      internship_place: ['', [Validators.required]],
      status: ['', [Validators.required]],
      employee_description: [''],
    });
  }

  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.dataSource.filter = filterValue.trim().toLowerCase();
  }

  open_edit_employee(row) {
    $('#modal_edit_employee').modal({
      backdrop: 'static',
      show: true,
    });
    console.log(row);
    this.id_personal = row.id_personal;
    this.form_edit_employee.controls['first_name'].setValue(row.first_name);
    this.form_edit_employee.controls['last_name'].setValue(row.last_name);
    this.form_edit_employee.controls['second_name'].setValue(row.second_name);
    this.form_edit_employee.controls['number_phone'].setValue(row.number_phone.substr(1));
    this.form_edit_employee.controls['test_date_1'].setValue(new Date(row.test_date_1));
    this.form_edit_employee.controls['test_number_ball_1'].setValue(row.test_number_ball_1);
    this.form_edit_employee.controls['test_date_2'].setValue(new Date(row.test_date_2));
    this.form_edit_employee.controls['test_number_ball_2'].setValue(row.test_number_ball_2);
    this.form_edit_employee.controls['internship_date'].setValue(new Date());
    this.form_edit_employee.controls['internship_place'].setValue(row.internship_place);
    this.form_edit_employee.controls['certification_date'].setValue(row.certification_date);
    this.form_edit_employee.controls['status'].setValue(row.status);
    this.form_edit_employee.controls['employee_description'].setValue(row.employee_description);
    console.log(new Date(row.interview_date));
    console.log(new Date(row.internship_date));
    console.log(this.form_edit_employee);

  }

}
