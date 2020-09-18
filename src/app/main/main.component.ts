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

  dataTable = [];
  displayedColumns: string[] = [
    'id_person',
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
    this.mainService.get_table_main().subscribe(res => {
      this.dataTable = JSON.parse(res)
      this.dataSource = new MatTableDataSource(this.dataTable);
      this.dataSource.sort = this.sort;
      this.dataSource.paginator = this.paginator;
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
    })
  }


  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.dataSource.filter = filterValue.trim().toLowerCase();
  }

  ngOnInit(): void {

  }

  openDialog(row, value): void {
    const dialogRef = this.dialog.open(ModalAdminComponent, {
      maxWidth: '500px',
      disableClose: true,
      data: {
        user_name: this.loginService.user_name,
        value: this.value,
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
