import { FocusMonitor } from '@angular/cdk/a11y';
import { Component, ViewChild } from '@angular/core';
import { MatSidenav } from '@angular/material/sidenav';
import { MatSnackBar } from '@angular/material/snack-bar';
import { LoginService } from './service/login.service';

declare var $: any;

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {


  @ViewChild('drawer') drawer: MatSidenav;



  title = 'Pizza Day DB';
  backgroundColorToggle = 'primary'
  program_v = ''
  user_id = this.loginService.user_id
  user_name = this.loginService.user_name
  user_role = this.loginService.user_role

  mode = 'over'

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
  main_page:boolean = false
  login_page:boolean = this.user_id === null ? true : false
  settings_page:boolean = false
  list_tt_page:boolean = false
  distribution_page:boolean = false
  report_page:boolean = false

  access_main = true
  access_settings:boolean
  access_list_tt:boolean
  access_distribution:boolean
  access_report:boolean


  constructor(
    private loginService: LoginService,
    private _snackBar: MatSnackBar,
    private _focusMonitor: FocusMonitor
  ){
    this.loginService.getUsersSettingsDistribution(this.user_id).subscribe(res => {
      this.array_page = JSON.parse(res)
      this.main_page = this.array_page[0].main_page
      this.list_tt_page = this.array_page[0].list_tt_page
      this.settings_page = this.array_page[0].settings_page
      this.distribution_page = this.array_page[0].distribution_page
      this.report_page = this.array_page[0].report_page
      this.access_settings = this.array_page[0].access_settings
      this.access_list_tt = this.array_page[0].access_list_tt
      this.access_distribution = this.array_page[0].access_distribution
      this.access_report = this.array_page[0].access_report
    })

    // console.log({'main':this.main = (this.user_id !== null) && (this.loginService.user_role === 'admin') ? true : false,'var main': this.main});
    // console.log({'main_user_hr': this.main_user_hr = (this.user_id !== null) && (this.loginService.user_role === 'user_hr') ? true : false,'var main': this.main_user_hr});
    // console.log({'main_user_hr': this.main_user_hr = (this.user_id !== null) || (this.loginService.user_role === 'user_hr') ? true : false});
    // console.log({'main':(this.user_id !== null) || (this.loginService.user_role === 'admin') ? true : false});


  }

  ngAfterViewInit() {
    this._focusMonitor.stopMonitoring(document.getElementById('buttonNav_1'));
}

  togglePage(items,access) {
    switch(this[access]){
      case true:
        this.main_page = false
        this.settings_page = false
        this.list_tt_page = false
        this.distribution_page = false
        this.report_page = false
        this[items] = true
        this.loginService.toggleUsersSettingsDistribution(this.user_id,this.main_page,this.settings_page,this.list_tt_page,this.distribution_page).subscribe(res =>{
          this.drawer.close();
        })
        break;
       case false:
        this._snackBar.open('У Вас нету прав!', '', {
          duration: 2000,
          horizontalPosition: 'center',
          verticalPosition: 'top',
          panelClass: 'alert-style-error'
        });
         break;
    }


    // console.log(this[items])
    // console.log(this.main_page,this.settings_page,this.list_tt_page,this.distribution_page);
  }

  logout() {
      localStorage.removeItem('id_user_pd')
      localStorage.removeItem('user_name_pd')
      localStorage.removeItem('user_role_pd')
      location.reload()
  }

  ngOnInit() {}
}
