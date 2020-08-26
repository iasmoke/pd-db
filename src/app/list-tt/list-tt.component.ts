import { Component, OnInit, ViewChild } from '@angular/core';
import { FormBuilder, FormControl, FormGroup } from '@angular/forms';
import { MatTableDataSource } from '@angular/material/table';
import { ListTtService } from '../service/list-tt.service';
import * as moment from 'moment';
import { DateAdapter, MAT_DATE_FORMATS, MAT_DATE_LOCALE } from '@angular/material/core';
import { MAT_MOMENT_DATE_ADAPTER_OPTIONS, MAT_MOMENT_DATE_FORMATS, MomentDateAdapter } from '@angular/material-moment-adapter';
moment.locale('ru');
declare var $: any;

@Component({
  selector: 'app-list-tt',
  templateUrl: './list-tt.component.html',
  styleUrls: ['./list-tt.component.scss'],
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
export class ListTtComponent implements OnInit {


  list_tt: any;
  spinner = true;
  hidden = true;
  search: any;

  alert_message:any;

  dataSource = new MatTableDataSource();

  displayedColumns: string[] = [
    'id_tt',
    'adress',
    'city',
    'date_open',
    'manager',
    'rm',
    'button'
  ];

  new_outlet: FormGroup;
  edit_outlet: FormGroup;

  constructor(
    private listTT: ListTtService,
    private formBuilder: FormBuilder
  ) {

    this.listTT.get_all().subscribe(res => {
      this.list_tt = JSON.parse(res)
      this.dataSource = new MatTableDataSource(this.list_tt);
      this.spinner = false
    })

    this.new_outlet = this.formBuilder.group({
      id_tt: new FormControl(),
      adress: new FormControl(),
      city: new FormControl(),
      date_open: new FormControl(),
      manager: new FormControl(),
      rm: new FormControl(),
    });

    this.edit_outlet = this.formBuilder.group({
      id_tt: new FormControl(),
      adress: new FormControl(),
      city: new FormControl(),
      date_open: new FormControl(),
      manager: new FormControl(),
      rm: new FormControl()
    });
  }

  getListTT(){
    this.listTT.get_all().subscribe(res => {
      this.list_tt = JSON.parse(res)
      this.dataSource = new MatTableDataSource(this.list_tt);
      this.spinner = false
    })
  }

  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.dataSource.filter = filterValue.trim().toLowerCase();
  }

  add_outlet() {
    this.listTT.add_outlet(this.new_outlet.value).subscribe(res => {
   
      this.alert_message = JSON.parse(res);
      if (this.alert_message === 'Торговая точка добавлена') {
        this.getListTT()
        $('#new_outlet_modal').modal('hide');
        $('#modalOutlet').modal('show');
        setTimeout(function () {
          $('#modalOutlet').modal('hide');
        }, 2000);
        this.new_outlet.reset();
      } else {
        console.log(this.alert_message);
        $('#modal_alert_add_error').modal('show');
        setTimeout(function () {
          $('#modal_alert_add_error').modal('hide');
        }, 4000);
      }
      
    })

  }

  pushChanges() {
    this.listTT.edit_outlet(this.edit_outlet.value).subscribe(res => {
      this.alert_message = JSON.parse(res);
      if (this.alert_message === 'Данные обновлены') {
        this.getListTT()
        $('#edit_outlet_modal').modal('hide');
        $('#modalOutlet').modal('show');
        setTimeout(function () {
          $('#modalOutlet').modal('hide');
        }, 2000);
      } else {
        console.log(this.alert_message);
        $('#modal_alert_add_error').modal('show');
        setTimeout(function () {
          $('#modal_alert_add_error').modal('hide');
        }, 2000);
      }
      
    })
  }

  openEdit(element) {
    $('#edit_outlet_modal').modal({
      backdrop: 'static',
      show: true,
    })
    this.edit_outlet.controls['id_tt'].setValue(element.id_tt);
    this.edit_outlet.controls['adress'].setValue(element.adress);
    this.edit_outlet.controls['city'].setValue(element.city);
    this.edit_outlet.controls['manager'].setValue(element.manager);
    this.edit_outlet.controls['rm'].setValue(element.rm);
    element.date_open === '' ? this.edit_outlet.controls['date_open'].setValue(element.date_open) : this.edit_outlet.controls['date_open'].setValue(moment(element.date_open, "DD.MM.YYYY"));

  }

  ngOnInit(): void {
  }



}
