import { Component, OnInit } from '@angular/core';
import { LoginService } from '../service/login.service';
import { HttpClient } from '@angular/common/http';
import { FormGroup, Validators, FormBuilder } from '@angular/forms';
import { MustMatch } from './must-match.validator';
declare var $: any;

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  error: any;
  userName = "";
  password = "";
  user_name_title: any;
  user_role:any

  constructor(
    private loginService: LoginService,
  ) {

  }

  logIn() {
    localStorage.removeItem('user_id')
    this.loginService.getLogin(this.userName, this.password).subscribe(res => {
      console.log(res)
      this.loginService.user_id = JSON.parse(res)['user_id']
      localStorage.setItem('id_user_pd', this.loginService.user_id);
      this.error = JSON.parse(res)['error']
      this.loginService.user_name = JSON.parse(res)['user_name'];
      this.loginService.user_role = JSON.parse(res)['user_role'];
      localStorage.setItem('user_name_pd', this.loginService.user_name);
      localStorage.setItem('user_role_pd', this.loginService.user_role);
      if (this.loginService.user_id !== null) {
        location.reload();
      }
    });
  }



  ngOnInit(): void {

  }
}
