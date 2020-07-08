import { Component, OnInit, ViewChild } from '@angular/core';
import { MatSort } from '@angular/material/sort';
import { MatTableDataSource } from '@angular/material/table';
import { MainService } from '../service/main.service';
import { FormGroup, FormBuilder, Validators, FormControl } from '@angular/forms';
import { MatPaginator } from '@angular/material/paginator';
import { LoginService } from '../service/login.service';
declare var $: any;
import * as moment from 'moment';

@Component({
  selector: 'app-main',
  templateUrl: './main.component.html',
  styleUrls: ['./main.component.scss']
})

export class MainComponent implements OnInit {

  dataTable = [];
  displayedColumns: string[] = ['id_personal','first_name','last_name','second_name','department','position','number_phone','interview_date','certification_date','date_birth','status','employee_description'];
  dataSource = new MatTableDataSource(this.dataTable);

  new_form_employee: FormGroup;
  form_edit_employee:FormGroup;

  office = false;
  trade_dot = false

 
  alert_message:any;
  id_tt:string[];

  array_data_employee = null
  modal_alert_message:any
  user_name_create_employee = this.loginService.user_name


  id_personal:any


  @ViewChild(MatSort, { static: false }) sort: MatSort;
  @ViewChild(MatPaginator, {static: true}) paginator: MatPaginator;

  constructor(
    private mainService:MainService,
    private formBuilder: FormBuilder,
    public loginService: LoginService,
  ) {
    this.mainService.get_table_main().subscribe(res => {
      this.dataTable = JSON.parse(res)
      this.dataSource = new MatTableDataSource(this.dataTable);
      this.dataSource.sort = this.sort;
      this.dataSource.paginator = this.paginator;
      console.log(res);
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

   get_table_personal(){
    this.mainService.get_table_main().subscribe(res => {
      this.dataTable = JSON.parse(res)
      this.dataSource = new MatTableDataSource(this.dataTable);
      this.dataSource.sort = this.sort;
      this.dataSource.paginator = this.paginator;
      console.log(res);
    })
   }

   add_employee(){
    if(this.new_form_employee.invalid){
      return console.log('new_form_employee.invalid');
      
    }
    let date_now = moment(new Date()).format('M.DD.YYYY HH:mm:ss')
     this.mainService.add_employee(this.user_name_create_employee, this.new_form_employee.value, date_now).subscribe(res => {
       console.log(res);
       console.log(this.new_form_employee);
     this.alert_message = JSON.parse(res)
     this.get_table_personal()
      if (this.alert_message === 'Пользователь добавлен') {
        
        $("#modalNew_user").modal("hide");
        $("#modalAddEmloyee").modal('show');
        setTimeout(function () {
          $("#modalAddEmloyee").modal('hide');
        }, 2000);
        this.new_form_employee.reset()
      }

     })
   }



   open_edit_employee(row){
    $("#modal_edit_employee").modal('show');
    console.log(row);
    this.mainService.get_data_employee(row.id_personal).subscribe(res => {
      this.array_data_employee = JSON.parse(res)
      this.id_personal = row.id_personal;
      this.form_edit_employee.controls['first_name'].setValue(this.array_data_employee[0].first_name);
      this.form_edit_employee.controls['last_name'].setValue(this.array_data_employee[0].last_name);
      this.form_edit_employee.controls['second_name'].setValue(this.array_data_employee[0].second_name);
      this.form_edit_employee.controls['interview_date'].setValue(this.array_data_employee[0].interview_date);
      this.form_edit_employee.controls['department'].setValue(this.array_data_employee[0].department);
      this.form_edit_employee.controls['position'].setValue(this.array_data_employee[0].position);
      this.form_edit_employee.controls['number_phone'].setValue(this.array_data_employee[0].number_phone);
      this.form_edit_employee.controls['certification_date'].setValue(this.array_data_employee[0].certification_date);
      this.form_edit_employee.controls['date_birth'].setValue(this.array_data_employee[0].date_birth);
      this.form_edit_employee.controls['status'].setValue(this.array_data_employee[0].status);
      this.form_edit_employee.controls['employee_description'].setValue(this.array_data_employee[0].employee_description);
    })
   }

   update_employee(){
    let date_now = moment(new Date()).format('M.DD.YYYY HH:mm:ss')
    this.mainService.update_employee(this.loginService.user_name, this.form_edit_employee.value, this.id_personal,date_now).subscribe(res => {
      console.log(res);
      this.modal_alert_message = JSON.parse(res)
      this.get_table_personal()
      $("#modal_edit_employee").modal("hide");
      $("#modal_alert_edit_employee").modal('show');
      setTimeout(function () {
        $("#modal_alert_edit_employee").modal('hide');
      }, 2000);
    })
   }

   applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.dataSource.filter = filterValue.trim().toLowerCase();
  }

  ngOnInit(): void {

    this.form_edit_employee = this.formBuilder.group({
      first_name: ['', Validators.required],
      last_name: ['', Validators.required],
      second_name: ['', Validators.required],
      department: ['', Validators.required],
      position: ['', Validators.required],
      number_phone: ['', [Validators.required, Validators.pattern("[0-9]{12}")]],
      interview_date:[''],
      certification_date: [''],
      date_birth: ['', Validators.required],
      status: ['',[Validators.required]],
      employee_description: [''],
    });

    this.new_form_employee = this.formBuilder.group({
      first_name: ['', Validators.required],
      last_name: ['', Validators.required],
      second_name: ['', Validators.required],
      type_department: ['', Validators.required],
      department: ['', Validators.required],
      position: ['', Validators.required],
      number_phone: ['', [Validators.required, Validators.pattern("[0-9]{12}")]],
      interview_date:[''],
      certification_date: [''],
      date_birth: ['', Validators.required],
      status: ['',[Validators.required]],
      employee_description: [''],
    });
  }

   get f() { return this.new_form_employee.controls;}

   get form_edit() {  return this.form_edit_employee.controls;}

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

}
