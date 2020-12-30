import { Component, OnInit, ViewChild } from '@angular/core';
import { MatSort } from '@angular/material/sort';
import { MatTableDataSource } from '@angular/material/table';
import { MainService } from '../service/main.service';
import { FormGroup, FormBuilder, Validators, FormControl } from '@angular/forms';
import { MatPaginator } from '@angular/material/paginator';
import { LoginService } from '../service/login.service';
import { MatDialog } from '@angular/material/dialog';
import { ModalAdminComponent } from '../modal-admin/modal-admin.component';
import * as moment from 'moment';
import { MatSnackBar } from '@angular/material/snack-bar';
import { saveAs } from 'file-saver';


moment.locale('ru')
declare var $: any;

export interface DialogData {
  user_name: string,
  value: string,
  row: any

}


@Component({
  selector: 'app-main',
  templateUrl: './main.component.html',
  styleUrls: ['./main.component.scss']
})

export class MainComponent implements OnInit {

  form: FormGroup;

  inlineRange;

  dataTable = [];
  displayedColumns: string[] = [
    'id_person',
    'fio',
    'department',
    'position',
    'number_phone',
    'interview_date',
    'status',
    'employee_description',
    'delete'
  ];
  dataSource = new MatTableDataSource(this.dataTable);

  value: any;
  search: any
  id_tt: string[];

  row_first_name: any
  row_last_name: any
  row_personal_id: any


  array_data_employee = null
  modal_alert_message: any
  user_name_create_employee = this.loginService.user_name

  id_person: any

  @ViewChild(MatSort, { static: false }) sort: MatSort;
  @ViewChild(MatPaginator, { static: true }) paginator: MatPaginator;

  constructor(
    private mainService: MainService,
    private formBuilder: FormBuilder,
    public loginService: LoginService,
    public dialog: MatDialog,
    private _snackBar: MatSnackBar
  ) {
    this.mainService.admin_main_table_get().subscribe(res => {
      this.dataTable = JSON.parse(res)
      this.dataSource = new MatTableDataSource(this.dataTable);
      this.dataSource.sort = this.sort;
      this.dataSource.paginator = this.paginator;
    })

    this.form = this.formBuilder.group({
      date: new FormControl ({begin:'', end:''})
    });

  }

  get_id_tt() {
    this.mainService.get_id_tt().subscribe(res => {
      this.id_tt = JSON.parse(res)
      console.log(this.id_tt);
    })
  }

  get_table_personal() {
    this.mainService.admin_main_table_get().subscribe(res => {
      this.dataTable = JSON.parse(res)
      this.dataSource = new MatTableDataSource(this.dataTable);
      this.dataSource.sort = this.sort;
      this.dataSource.paginator = this.paginator;
    })
  }


  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.dataSource.filter = filterValue.trim().toLowerCase();
  }

  inlineRangeChange($event) {
    this.inlineRange = $event;
  }

  downloadFile(data: any) {
    const replacer = (key, value) => (value === null ? '' : value); // specify how you want to handle null values here
    const header = Object.keys(data[0]);
    const csv = data.map((row) =>
      header
        .map((fieldName) => JSON.stringify(row[fieldName], replacer))
        .join(',')
    );
    csv.unshift(header.join(','));
    const csvArray = csv.join('\r\n');

    const a = document.createElement('a');
    const blob = new Blob([csvArray], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);

    a.href = url;
    a.download = 'myFile.csv';
    a.click();
    window.URL.revokeObjectURL(url);
    a.remove();
  }

  downloadFileCSV(){
    this.mainService.admin_get_attraction_channel(this.form.value).subscribe(res => {
      console.log(res);
      this.downloadFile(JSON.parse(res))

    })
  }

  ngOnInit(): void {

  }

  openDialog(row, value): void {
    const dialogRef = this.dialog.open(ModalAdminComponent, {
      maxWidth: '500px',
      disableClose: true,
      data: {
        user_name: this.loginService.user_name,
        value: value,
        row: row
      }
    });

    dialogRef.afterClosed().subscribe(result => {
      console.log(result);
      switch (result) {
        case 'Пользователь добавлен':
          this._snackBar.open(result, '', {
            duration: 2000,
            horizontalPosition: 'center',
            verticalPosition: 'top',
            panelClass: 'alert-style-success'
          });
          this.get_table_personal();
          break;
        case 'Данные обновлены':
          this._snackBar.open(result, '', {
            duration: 2000,
            horizontalPosition: 'center',
            verticalPosition: 'top',
            panelClass: 'alert-style-success'
          });
          this.get_table_personal();
          this.search = ''
          break;
        case 'Пользователь удален':
          this._snackBar.open(result, '', {
            duration: 2000,
            horizontalPosition: 'center',
            verticalPosition: 'top',
            panelClass: 'alert-style-success'
          });
          this.get_table_personal();
          this.search = ''
          break;
      }
    })
  }
}
