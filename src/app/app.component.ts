import { Component } from '@angular/core';
import { LoginService } from './service/login.service';
import { HttpClient } from '@angular/common/http';
import { FormBuilder, Validators, FormGroup, FormControl } from '@angular/forms';
import { MatIconRegistry } from '@angular/material/icon';
import { DomSanitizer } from '@angular/platform-browser';
// import { TimerService } from './service/timer.service';
// import { TimerObservable } from "rxjs/observable/TimerObservable";
// import 'rxjs/add/operator/takeWhile'
// import { TradingSetting } from './service/trading_setting.service';
// import { ModalOpenLogComponent } from './modal-open-log/modal-open-log.component';
// import { BacktestsService } from './service/backtests.service';
// import { DataService } from './service/data.service';
// import { min } from 'rxjs/operators';
// import { MustMatch } from '././login/must-match.validator';
// import { TradingSettingsComponent } from './trading-settings/trading-settings.component';
// import { timingSafeEqual } from 'crypto';


// declare var $: any;

// export interface ModalLastLog {
//   log_text: any;
// }



@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {

  title = 'Pizza Day';
  login_component = true

  constructor(){
  }

  ngOnInit() {}
}
