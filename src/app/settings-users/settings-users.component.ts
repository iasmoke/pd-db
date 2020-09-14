import { Component, OnInit, ViewChild } from '@angular/core';
import { SettingsUsersService } from '../service/settings-users.service';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { LoginService } from '../service/login.service';
import { MustMatch } from '../login/must-match.validator';
import { MatAccordion } from '@angular/material/expansion';


declare var $: any;

@Component({
  selector: 'app-settings-users',
  templateUrl: './settings-users.component.html',
  styleUrls: ['./settings-users.component.scss']
})
export class SettingsUsersComponent implements OnInit {

  @ViewChild(MatAccordion) accordion: MatAccordion;
  panelOpenState = false;

  error_register: any;
  users_array:any;
  hide = true
  user_settings_obj:FormGroup
  modal_alert_message:any;
 
  
  

  constructor(
    private settingsUsers:SettingsUsersService,
    private loginService:LoginService,
    private formBuilder: FormBuilder,
  ) {
    this.settingsUsers.get_users().subscribe(res => {
      this.users_array = JSON.parse(res);
    })
  }


  // update_user_settings(index){
  //   this.settingsUsers.
   
  // }
  get_users_settings(){
    this.settingsUsers.get_users().subscribe(res => {
      this.users_array = JSON.parse(res);
    })
  }




  update_user_settings(index){
  this.settingsUsers.update_user_settings(
    this.users_array[index].user_id,
    this.users_array[index].first_name,
    this.users_array[index].last_name,
    this.users_array[index].user_name,
    this.users_array[index].password,
    this.users_array[index].user_role,
    ).subscribe(res => {
      console.log(res);
      this.modal_alert_message = JSON.parse(res).toString()
      if (this.modal_alert_message === 'Данные обновлены') {
        $("#alert_users_settings_update").modal('show');
        setTimeout(function () {
          $("#alert_users_settings_update").modal('hide');
        }, 2000);
      }
    })
    
  }
  

  ngOnInit(): void {

  }

  

}
