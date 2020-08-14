import { Component } from '@angular/core';
import { LoginService } from './service/login.service';

declare var $: any;

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {

  title = 'Pizza Day DB';
  backgroundColorToggle = 'primary'
  program_v = ''
  user_id = this.loginService.user_id
  user_name = this.loginService.user_name
  user_role = this.loginService.user_role
  

  
  main = ((this.user_id !== null) && (this.loginService.user_role === 'admin')) ? true : false;
  main_user_hr = ((this.user_id !== null) && (this.loginService.user_role === 'user_hr')) ? true : false;
  main_user_mt = ((this.user_id !== null) && (this.loginService.user_role === 'user_mt')) ? true : false;
  main_user_pi = ((this.user_id !== null) && (this.loginService.user_role === 'user_pi')) ? true : false;
  login_component = this.user_id === null ? true : false;
  settings_users = false;
  list_tt = false
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
    this.list_tt = false
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
