import { SelectionModel } from '@angular/cdk/collections';
import { Component, Inject, OnInit, ViewChild } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { MatPaginator } from '@angular/material/paginator';
import { MatSnackBar } from '@angular/material/snack-bar';
import { MatSort } from '@angular/material/sort';
import { MatTableDataSource } from '@angular/material/table';
import { DialogData } from '../main/main.component';
import { MainService } from '../service/main.service';
import { TestsService } from '../service/tests.service';

@Component({
  selector: 'app-modal-mt',
  templateUrl: './modal-mt.component.html',
  styleUrls: ['./modal-mt.component.scss']
})
export class ModalMtComponent implements OnInit {

  formValueAdd = this.data.value === 'new_test' ? true : false;
  boolean_list_person = this.data.value === 'new_testing_for_person' ? true : false;



  newTest: FormGroup;
  modal_alert_message: any
  list_position: any


  search = ''
  list_persons = [];

  list_name_tests: string[];

  name_test = '';


  displayedColumns: string[] = [
    'select',
    'fi',
    'department',
    'position'
  ];

  selection = new SelectionModel(true, []);
  dataSource = new MatTableDataSource();

  @ViewChild(MatSort) sort: MatSort;
  @ViewChild(MatPaginator) paginator: MatPaginator;



  constructor(
    public dialogRef: MatDialogRef<ModalMtComponent>,
    @Inject(MAT_DIALOG_DATA) public data: DialogData,
    public formBuilder: FormBuilder,
    private mainService: MainService,
    private _snackBar: MatSnackBar,
    private testsService: TestsService
  ) {
    switch (this.data.value) {
      case 'new_testing_for_person':
        this.testsService.tests_get_list_persons().subscribe(res => {
          this.list_persons = JSON.parse(res);
          this.dataSource = new MatTableDataSource(this.list_persons);
          this.dataSource.sort = this.sort;
          this.dataSource.paginator = this.paginator;
          this.selection = new SelectionModel(true, []);
        })

        this.testsService.tests_get_name_tests().subscribe(res => {
          this.list_name_tests = JSON.parse(res)
        })
        break;
      case 'new_test':
        this.testsService.tests_get_list_position().subscribe(res => {
          this.list_position = JSON.parse(res);
        })
        break;
    }
  }

  get fn() {
    switch (this.data.value) {
      case 'new_test':
        return this.newTest.controls;

      case 'new_testing_for_person':
        console.log('new_testing_for_person');
        break;
    }
  }


  ngOnInit(): void {
    switch (this.data.value) {
      case 'new_test':
        this.newTest = this.formBuilder.group({
          name_test: new FormControl('', Validators.required),
          description_test: new FormControl(''),
          max_score: new FormControl('',[Validators.max(200), Validators.required]),
          position_type: new FormControl('', Validators.required),
        });
        break;
    }
  }

  addPersons() {
    switch (this.name_test) {
      case '':
        this._snackBar.open("Выберете для начала тест", 'Закрыть', {
          duration: 5000,
          horizontalPosition: 'center',
          verticalPosition: 'top',
          panelClass: 'alert-style-error'
        });
        break;
      default:
        this.testsService.tests_check_persons_for_match(this.selection.selected, this.name_test).subscribe(res => {
          this.modal_alert_message = JSON.parse(res);
          switch (this.modal_alert_message) {
            case 'done':
              this.testsService.tests_add_testing_for_person(this.selection.selected, this.name_test).subscribe(res => {
                this.modal_alert_message = JSON.parse(res)
                switch (this.modal_alert_message) {
                  case 'Готово!':
                    this.dialogRef.close(this.modal_alert_message)
                    break;
                  default:
                    this._snackBar.open(this.modal_alert_message[0].error, '', {
                      duration: 7000,
                      horizontalPosition: 'center',
                      verticalPosition: 'top',
                      panelClass: 'alert-style-error'
                    });
                    break;
                }
              })
              break;
            default:
              this._snackBar.open(this.modal_alert_message, '', {
                duration: 7000,
                horizontalPosition: 'center',
                verticalPosition: 'top',
                panelClass: 'alert-style-error'
              });
              break;
          }
        })
        break;
    }
  }

  addNewTest() {
    switch (this.newTest.invalid) {
      case true:
        console.log('false');
        break;
      default:
        this.testsService.tests_add_new_test(this.newTest.value).subscribe(res => {
          this.modal_alert_message = JSON.parse(res)
          switch (this.modal_alert_message) {
            case 'Новый тест добавлен':
              this.dialogRef.close(this.modal_alert_message)
              break;
            default:
              this._snackBar.open(this.modal_alert_message[0].error, '', {
                duration: 7000,
                horizontalPosition: 'center',
                verticalPosition: 'top',
                panelClass: 'alert-style-error'
              });
              break;
          }
        })
        break;
    }

  }


  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.dataSource.filter = filterValue.trim().toLowerCase();
  }
  /** Whether the number of selected elements matches the total number of rows. */
  isAllSelected() {
    const numSelected = this.selection.selected.length;
    const numRows = this.dataSource.data.length;
    return numSelected === numRows;
  }

  /** Selects all rows if they are not all selected; otherwise clear selection. */
  masterToggle() {
    this.isAllSelected() ?
      this.selection.clear() :
      this.dataSource.data.forEach(row => this.selection.select(row));
  }

  /** The label for the checkbox on the passed row */
  checkboxLabel(row?): string {
    if (!row) {
      return `${this.isAllSelected() ? 'select' : 'deselect'} all`;
    }
    return `${this.selection.isSelected(row) ? 'deselect' : 'select'} row ${row.position + 1}`;
  }

}
