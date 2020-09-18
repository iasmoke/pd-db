import { Component, OnInit, ViewChild } from '@angular/core';
import { FormControl, FormGroup, FormBuilder, Validators } from '@angular/forms';
import { MatTableDataSource } from '@angular/material/table';
import { MatSort } from '@angular/material/sort';
import { MatPaginator } from '@angular/material/paginator';
import { MainService } from '../service/main.service';
import { LoginService } from '../service/login.service';
import * as moment from 'moment';
import { ModalMtComponent } from '../modal-mt/modal-mt.component';
import { MatDialog } from '@angular/material/dialog';
import { MatSnackBar } from '@angular/material/snack-bar';


export interface DialogData {
  user_name: string,
  value: string,
  row: any
}

@Component({
  selector: 'app-main-user-mt',
  templateUrl: './main-user-mt.component.html',
  styleUrls: ['./main-user-mt.component.scss']
})
export class MainUserMtComponent implements OnInit {

  id_tt: string[];
  search: any
  dataTable_user_mt = [];
  displayedColumns: string[] = [
    'fio',
    'name_test',
    'test_score',
    'passing_date',
    'type_department',
    'department',
    'position',
    'button'
  ];
  dataSource = new MatTableDataSource();

  nameTestsList:string[];


  modal_alert_message: any;
  name_test = 'all'
  passing_date = 'all'

  @ViewChild(MatSort, { static: false }) sort: MatSort;
  @ViewChild(MatPaginator, { static: true }) paginator: MatPaginator;

  constructor(
    private mainService: MainService,
    private formBuilder: FormBuilder,
    public loginService: LoginService,
    public dialog: MatDialog,
    private _snackBar: MatSnackBar

  ) {
    this.mainService.user_mt_main_table_get(this.name_test, this.passing_date).subscribe((res) => {
      this.dataTable_user_mt = JSON.parse(res);
      console.log(this.dataTable_user_mt);

      this.dataSource = new MatTableDataSource(this.dataTable_user_mt);
      this.dataSource.sort = this.sort;
      this.dataSource.paginator = this.paginator;
    });

    this.mainService.get_id_tt().subscribe(res => {
      this.id_tt = JSON.parse(res)
    });

    this.mainService.tests_get_name_tests().subscribe(res => {
      this.nameTestsList = JSON.parse(res)
    })
  }


  ngOnInit(): void {

  }

  openDialog(row, value): void {
    const dialogRef = this.dialog.open(ModalMtComponent, {
      maxWidth: '400px',
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
        case 'Новый тест добавлен':
          this._snackBar.open(result, '', {
            duration: 2000,
            horizontalPosition: 'center',
            verticalPosition: 'top',
            panelClass: 'alert-style-success'
          });
          this.get_table_personal();
          break;
      }
    })
  }

  get_table_personal() {
    this.mainService.user_mt_main_table_get(this.name_test, moment.parseZone(this.passing_date).format('YYYY-MM-DD')).subscribe((res) => {
      console.log(this.name_test);
      this.dataTable_user_mt = JSON.parse(res);
      this.dataSource = new MatTableDataSource(this.dataTable_user_mt);
      this.dataSource.sort = this.sort;
      this.dataSource.paginator = this.paginator;
    });
  }

  saveChanges(row){
    this.mainService.tests_save_changes_table(row.id_person,row.test_score,moment.parseZone(row.passing_date).format('YYYY-MM-DD')).subscribe(res => {
      this.modal_alert_message = JSON.parse(res)
      console.log(this.modal_alert_message);
      switch(this.modal_alert_message){
      case 'Данные обновлены':
        this._snackBar.open(this.modal_alert_message, '', {
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

  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.dataSource.filter = filterValue.trim().toLowerCase();
  }

}
