import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class ReportPageService {

  constructor(
    private http: HttpClient
  ) { }

  report_get_table(type_reports) {
    return this.http.post(
      './assets/php/report_get_table.php',
      JSON.stringify(
        {
          type_reports:type_reports
        }
      ),
      { responseType: 'text' }
    )
  }

  report_get_type_reports_list(){
    return this.http.post(
      './assets/php/report_get_type_reports_list.php',
      JSON.stringify(
        {
        }
      ),
      { responseType: 'text' }
    )
  }
  

}
