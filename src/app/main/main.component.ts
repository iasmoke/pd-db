import { Component, OnInit, ViewChild } from '@angular/core';
import { MatSort } from '@angular/material/sort';
import { MatTableDataSource } from '@angular/material/table';
import { MainService } from '../service/main.service';
import { FormGroup, FormBuilder, Validators, FormControl } from '@angular/forms';
import { MatPaginator } from '@angular/material/paginator';
import { LoginService } from '../service/login.service';
declare var $: any;
import * as moment from 'moment';
moment.locale('ru')

@Component({
  selector: 'app-main',
  templateUrl: './main.component.html',
  styleUrls: ['./main.component.scss']
})

export class MainComponent implements OnInit {

  dataTable = [];
  displayedColumns: string[] = ['id_personal','first_name','last_name','second_name','department','position','number_phone','interview_date','certification_date','date_birth','status','employee_description'];
  dataSource = new MatTableDataSource(this.dataTable);

  new_form: FormGroup;
  edit_form:FormGroup;

  office = true;
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

   get_table_personal(){
    this.mainService.get_table_main().subscribe(res => {
      this.dataTable = JSON.parse(res)
      this.dataSource = new MatTableDataSource(this.dataTable);
      this.dataSource.sort = this.sort;
      this.dataSource.paginator = this.paginator;
      console.log(this.dataTable);
    })
   }

   add_employee(){
    if(this.new_form.invalid){
      return console.log('new_form.invalid');
    }
    let date_now = moment(new Date()).format('M.DD.YYYY HH:mm:ss')
     this.mainService.add_employee(this.new_form.value, date_now, this.user_name_create_employee).subscribe(res => {
     this.alert_message = JSON.parse(res)
     console.log(this.alert_message);
     this.get_table_personal()
      if (this.alert_message === 'Пользователь добавлен') {
        
        $("#modalNew_user").modal("hide");
        $("#modalAddEmloyee").modal('show');
        setTimeout(function () {
          $("#modalAddEmloyee").modal('hide');
        }, 2000);
        this.new_form.reset()
      }

     })
   }



   open_edit_employee(row){
    $("#modal_edit_employee").modal('show');
    console.log(row);
    this.mainService.get_data_employee(row.id_personal).subscribe(res => {
      this.array_data_employee = JSON.parse(res)
      console.log(this.array_data_employee);
      this.id_personal = row.id_personal;
      this.edit_form.controls['first_name'].setValue(this.array_data_employee[0].first_name);
      this.edit_form.controls['last_name'].setValue(this.array_data_employee[0].last_name);
      this.edit_form.controls['second_name'].setValue(this.array_data_employee[0].second_name);
      this.edit_form.controls['interview_date'].setValue(this.array_data_employee[0].interview_date);
      this.edit_form.controls['type_department'].setValue(this.array_data_employee[0].type_department);
      this.edit_form.controls['department'].setValue(this.array_data_employee[0].department);
      this.edit_form.controls['position'].setValue(this.array_data_employee[0].position);
      this.edit_form.controls['number_phone'].setValue(this.array_data_employee[0].number_phone);
      this.edit_form.controls['certification_date'].setValue(this.array_data_employee[0].certification_date);
      this.edit_form.controls['date_birth'].setValue(this.array_data_employee[0].date_birth);
      this.edit_form.controls['status'].setValue(this.array_data_employee[0].status);
      this.edit_form.controls['employee_description'].setValue(this.array_data_employee[0].employee_description);
    })
   }

   update_employee(){
    let date_now = moment(new Date()).format('M.DD.YYYY HH:mm:ss')
    this.mainService.update_employee(this.loginService.user_name, this.edit_form.value, this.id_personal,date_now).subscribe(res => {
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
      second_name: ['', Validators.required],
      department: ['', Validators.required],
      position: ['', Validators.required],
      type_department: ['', Validators.required],
      number_phone: ['', [Validators.required, Validators.pattern("[0-9]{12}")]],
      interview_date:[''],
      certification_date: [''],
      date_birth: [''],
      status: ['',[Validators.required]],
      employee_description: [''],
    });

    this.new_form = this.formBuilder.group({
      first_name: ['', Validators.required],
      last_name: ['', Validators.required],
      second_name: ['', Validators.required],
      type_department: ['', Validators.required],
      department: ['', Validators.required],
      position: ['', Validators.required],
      number_phone: ['', [Validators.required, Validators.pattern("[0-9]{12}")]],
      interview_date:[''],
      certification_date: [''],
      date_birth: [''],
      status: ['',[Validators.required]],
      employee_description: [''],
    });

    this.onChangesPosition() 
  }

   get fn() { return this.new_form.controls;}

   get fe() {  return this.edit_form.controls;}

  

}
