import { Component, OnInit, ViewChild } from '@angular/core';
import { MatTableDataSource } from '@angular/material/table';
import { ReportPageService } from 'src/app/service/report-page.service'
import * as moment from 'moment';
import { MatPaginator } from '@angular/material/paginator';
import { CdkTextareaAutosize } from '@angular/cdk/text-field';

@Component({
  selector: 'app-report-page',
  templateUrl: './report-page.component.html',
  styleUrls: ['./report-page.component.scss']
})
export class ReportPageComponent implements OnInit {

  modal_alert_message:any
  report_list: string[]
  search:any
  type_reports = 'all'
  type_reports_list:string[]

  @ViewChild('autosize') autosize: CdkTextareaAutosize;

  dataSource = new MatTableDataSource();
  @ViewChild(MatPaginator, { static: true }) paginator: MatPaginator;

  displayedColumns: string[] = [
    'id',
    'fi',
    'number_phone',
    'department',
    'position',
    'type_reports',
    'description',
    'date_time'
  ];


  constructor(
    private reportPage:ReportPageService
  ) {
    this.reportPage.report_get_table(this.type_reports).subscribe(res => {
      this.report_list = JSON.parse(res)
      this.dataSource = new MatTableDataSource(this.report_list);
      this.dataSource.paginator = this.paginator;
    })
    this.reportPage.report_get_type_reports_list().subscribe(res => {
      this.type_reports_list = JSON.parse(res);
    })
  }

  ngModalChangeTypeReportList(){
    this.reportPage.report_get_table(this.type_reports).subscribe(res => {
      this.report_list = JSON.parse(res)
      this.dataSource = new MatTableDataSource(this.report_list);
      this.dataSource.paginator = this.paginator;
    })
  }

  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.dataSource.filter = filterValue.trim().toLowerCase();
  }

  ngOnInit(): void {
  }

}
