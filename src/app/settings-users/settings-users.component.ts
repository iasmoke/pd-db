import { Component, OnInit, ViewChild } from '@angular/core';
import { SettingsUsersService } from '../service/settings-users.service';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
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

  registerForm: FormGroup;

  error_register: any;
  users_array:any;
  hide = true
  user_settings_obj:FormGroup
  alert_update:any;
 
  
  

  constructor(
    private settingsUsers:SettingsUsersService,
    private loginService:LoginService,
    private formBuilder: FormBuilder,
  ) {}


  // update_user_settings(index){
  //   this.settingsUsers.
   
  // }
  get_users_settings(){
    this.settingsUsers.get_users().subscribe(res => {
      console.log(res);
      this.users_array = JSON.parse(res);
      console.log(this.users_array);
    })
  }


  register() {
    if (this.registerForm.invalid) {
      return console.log('false');
    } else {
      this.loginService.registerUser(this.registerForm.value).subscribe(res => {
        this.error_register = JSON.parse(res).toString()
        console.log(this.error_register);
        if (this.error_register === 'Registration successful') {
          this.registerForm.reset()
          this.get_users_settings()
          $("#register_user").modal("hide")
          $("#myModalError_register").modal('show');
          setTimeout(function () {
            $("#myModalError_register").modal('hide');
          }, 2000);

        }
      });
    }

  }
  udpate_user_settings(index){
  this.settingsUsers.update_user_settings(
    this.users_array[index].user_id,
    this.users_array[index].first_name,
    this.users_array[index].last_name,
    this.users_array[index].user_name,
    this.users_array[index].password,
    this.users_array[index].user_role,
    ).subscribe(res => {
      console.log(res);
      this.alert_update = JSON.parse(res).toString()
      if (this.alert_update === 'Данные обновлены') {
        $("#alert_users_settings_update").modal('show');
        setTimeout(function () {
          $("#alert_users_settings_update").modal('hide');
        }, 2000);
      }
    })
    
  }
  

  ngOnInit(): void {
    this.settingsUsers.get_users().subscribe(res => {
      console.log(res);
      this.users_array = JSON.parse(res);
      console.log(this.users_array);
    })

    // this.user_settings_obj = this.formBuilder.group({
    //   first_name: ['',Validators.required],
    //   last_name: ['',Validators.required],
    //   user_name: ['',Validators.required],
    //   password: [['',Validators.required, Validators.minLength(6)]],
    //   user_role: ['',Validators.required]
    // })
    
    this.registerForm = this.formBuilder.group({
      userName: ['', Validators.required],
      password: ['', [Validators.required, Validators.minLength(6)]],
      confirmPassword: ['', Validators.required],
      first_name: ['', Validators.required],
      last_name: ['', Validators.required],
      user_role: ['', Validators.required]
    }, {
      validator: MustMatch('password', 'confirmPassword')
    });
    
  }

  get f() { return this.registerForm.controls; }

}
