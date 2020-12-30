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
import { TestsService } from '../service/tests.service';


export interface DialogData {
  user_name: string,
  value: string,
  row: any
}

@Component({
  selector: 'app-tests',
  templateUrl: './tests.component.html',
  styleUrls: ['./tests.component.scss']
})
export class TestsComponent implements OnInit {


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
    'internship_date'
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
    private _snackBar: MatSnackBar,
    private testsService: TestsService

  ) {
    this.mainService.user_mt_main_table_get(this.name_test, this.passing_date).subscribe((res) => {
      this.dataTable_user_mt = JSON.parse(res);
      this.dataSource = new MatTableDataSource(this.dataTable_user_mt);
      this.dataSource.sort = this.sort;
      this.dataSource.paginator = this.paginator;
    });

    this.mainService.get_id_tt().subscribe(res => {
      this.id_tt = JSON.parse(res)
    });

    this.testsService.tests_get_name_tests().subscribe(res => {
      this.nameTestsList = JSON.parse(res)
    })
  }


  ngOnInit(): void {

  }

  openDialog(row, value): void {
    switch(value){
      case 'new_testing_for_person':
        const dialogRef_new_testing_for_person = this.dialog.open(ModalMtComponent, {
          width: '900px',
          maxHeight: '600px',
          disableClose: true,
          data: {
            user_name: this.loginService.user_name,
            value: value,
            row: row
          }
        });

        dialogRef_new_testing_for_person.afterClosed().subscribe(result => {
          console.log(result);
          switch (result) {
            case 'Готово!':
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
        break;


    case 'new_test':

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
    break;
  }
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
    this.testsService.tests_save_changes_table(row.id_person,row.test_score,moment.parseZone(row.passing_date).format('YYYY-MM-DD'),row.name_test).subscribe(res => {
      this.modal_alert_message = JSON.parse(res)
    })

  }

  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.dataSource.filter = filterValue.trim().toLowerCase();
  }


}
