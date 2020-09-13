import { Component, OnInit, ViewChild } from '@angular/core';
import { MatTableDataSource } from '@angular/material/table';
import { ListTtService } from '../service/list-tt.service';
import { ModalListTtComponent } from '../modal-list-tt/modal-list-tt.component';
import { MatDialog } from '@angular/material/dialog';
import { MatSnackBar } from '@angular/material/snack-bar';
declare var $: any;

export interface DialogData {
  value: string,
  row: any

}

@Component({
  selector: 'app-list-tt',
  templateUrl: './list-tt.component.html',
  styleUrls: ['./list-tt.component.scss'],
})
export class ListTtComponent implements OnInit {


  list_tt: any;
  value: any;
  search:any

  dataSource = new MatTableDataSource();

  displayedColumns: string[] = [
    'number_td',
    'address',
    'city',
    'date_open',
    'manager',
    'rm',
    'button'
  ];

  constructor(
    private listTT: ListTtService,
    public dialog: MatDialog,
    private _snackBar: MatSnackBar
  ) {
    this.listTT.get_all().subscribe(res => {
      this.list_tt = JSON.parse(res)
      this.dataSource = new MatTableDataSource(this.list_tt);
    })
  }

  getListTT(){
    this.listTT.get_all().subscribe(res => {
      this.list_tt = JSON.parse(res)
      this.dataSource = new MatTableDataSource(this.list_tt);
    })
  }

  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.dataSource.filter = filterValue.trim().toLowerCase();
  }

 

  openDialog(row, value): void {
    const dialogRef = this.dialog.open(ModalListTtComponent, {
      maxWidth: '500px',
      disableClose: true,
      data: {
        value: value,
        row: row
      }
    });

    dialogRef.afterClosed().subscribe(result => {
      console.log(result);
      switch (result) {
        case 'Торговая точка добавлена':
          this._snackBar.open(result, '', {
            duration: 2000,
            horizontalPosition: 'center',
            verticalPosition: 'top',
            panelClass: 'alert-style-success'
          });
          this.getListTT();
          this.search = ''
          break;
        case 'Данные обновлены':
          this._snackBar.open(result, '', {
            duration: 2000,
            horizontalPosition: 'center',
            verticalPosition: 'top',
            panelClass: 'alert-style-success'
          });
          this.getListTT();
          this.search = ''
          break;
      }
    })
  }

  ngOnInit(): void {
  }



}
