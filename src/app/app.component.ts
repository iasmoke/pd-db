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

  mode = 'push'

  array_page: any
  

  // distribution_telegram = false
  // main = ((this.user_id !== null) && (this.loginService.user_role === 'admin')) ? true : false;
  // main_user_hr = ((this.user_id !== null) && (this.loginService.user_role === 'user_hr')) ? true : false;
  // main_user_mt = ((this.user_id !== null) && (this.loginService.user_role === 'user_mt')) ? true : false;
  // main_user_pi = ((this.user_id !== null) && (this.loginService.user_role === 'user_pi')) ? true : false;
  // login_component = this.user_id === null ? true : false;
  // settings_users = false;
  // list_tt = false
  // telegram_send = false;
  main_page = false
  login_page = this.user_id === null ? true : false
  settings_page = false
  list_tt_page = false
  distribution_page = false

  constructor(
    private loginService: LoginService,
  ){
    this.loginService.getUsersSettingsDistribution(this.user_id).subscribe(res => {
      this.array_page = JSON.parse(res)
      this.main_page = this.array_page[0].main_page
      this.login_page = this.array_page[0].login_page
      this.settings_page = this.array_page[0].settings_page
      this.distribution_page = this.array_page[0].distribution_page
      console.log(this.array_page);
    })

    // console.log({'main':this.main = (this.user_id !== null) && (this.loginService.user_role === 'admin') ? true : false,'var main': this.main});
    // console.log({'main_user_hr': this.main_user_hr = (this.user_id !== null) && (this.loginService.user_role === 'user_hr') ? true : false,'var main': this.main_user_hr});
    // console.log({'main_user_hr': this.main_user_hr = (this.user_id !== null) || (this.loginService.user_role === 'user_hr') ? true : false});
    // console.log({'main':(this.user_id !== null) || (this.loginService.user_role === 'admin') ? true : false});
    
    
  }

  // toggle_component(items) {
  //   this.loginService
  //   this.main_page = false
  //   this.login_page = false
  //   this.settings_page = false
  //   this.list_tt_page = false
  //   this.distribution_page = false
  //   this[items] = true
  // }

  logout() {
      localStorage.removeItem('id_user_pd')
      localStorage.removeItem('user_name_pd')
      localStorage.removeItem('user_role_pd')
      location.reload()
  }

  ngOnInit() {}
}
