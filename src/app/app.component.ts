import { Component } from '@angular/core';
import { LoginService } from './service/login.service';
// import { HttpClient } from '@angular/common/http';
// import { FormBuilder, Validators, FormGroup, FormControl } from '@angular/forms';
// import { MatIconRegistry } from '@angular/material/icon';
// import { DomSanitizer } from '@angular/platform-browser';
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


declare var $: any;

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
  backgroundColorToggle = 'primary'
  program_v = 'v1.0'
  user_id = this.loginService.user_id
  user_name = this.loginService.user_name
  user_role = this.loginService.user_role
  

  
  main = ((this.user_id !== null) && (this.loginService.user_role === 'admin')) ? true : false;
  main_user_hr = ((this.user_id !== null) && (this.loginService.user_role === 'user_hr')) ? true : false;
  main_user_mt = ((this.user_id !== null) && (this.loginService.user_role === 'user_mt')) ? true : false;
  main_user_pi = ((this.user_id !== null) && (this.loginService.user_role === 'user_pi')) ? true : false;
  login_component = this.user_id === null ? true : false;
  settings_users = false;
  // telegram_send = false;
  


  constructor(
    private loginService: LoginService,
  ){
    // console.log({'main':this.main = (this.user_id !== null) && (this.loginService.user_role === 'admin') ? true : false,'var main': this.main});
    // console.log({'main_user_hr': this.main_user_hr = (this.user_id !== null) && (this.loginService.user_role === 'user_hr') ? true : false,'var main': this.main_user_hr});
    // console.log({'main_user_hr': this.main_user_hr = (this.user_id !== null) || (this.loginService.user_role === 'user_hr') ? true : false});
    // console.log({'main':(this.user_id !== null) || (this.loginService.user_role === 'admin') ? true : false});
    
    
  }

  select_component(items) {
    this.settings_users = false
    this.login_component = false
    this.main = false
    // this.telegram_send = false
    this[items] = true
  }

  logout() {
    localStorage.removeItem('id_user_pd')
    localStorage.removeItem('user_name_pd')
    localStorage.removeItem('user_role_pd')
    location.reload()
  }

  ngOnInit() {}
}
