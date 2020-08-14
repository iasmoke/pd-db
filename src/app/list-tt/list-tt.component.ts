import { Component, OnInit, ViewChild } from '@angular/core';
import { MatAccordion } from '@angular/material/expansion';
import { ListTtService } from '../service/list-tt.service';

@Component({
  selector: 'app-list-tt',
  templateUrl: './list-tt.component.html',
  styleUrls: ['./list-tt.component.scss']
})
export class ListTtComponent implements OnInit {


  list_tt:any;
  spinner = true;
  @ViewChild(MatAccordion) accordion: MatAccordion;
  constructor(
    private send_list:ListTtService
  ) {

    this.send_list.get_all().subscribe(res => {
      console.log(res);
      this.list_tt = JSON.parse(res);
      this.spinner = false
    })
   }

  ngOnInit(): void {
  }

}
