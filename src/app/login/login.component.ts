import { Component, OnInit } from '@angular/core';
import { LoginService } from '../service/login.service';
import { HttpClient } from '@angular/common/http';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { MustMatch } from './must-match.validator';
declare var $: any;

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  user_id = this.loginService.user_id;

  userName = "";
  password = "";
  user_name_title: any;
  error: any;

  pageOne = this.user_id !== null ? true : false;
  userPage = false;
  backTestReport = false;
  login = this.user_id === null ? true : false

  
  

 
  constructor(
    private loginService: LoginService,
    private http: HttpClient,
  ) { }

  logIn() {
    localStorage.removeItem('user_id')
    this.loginService.getLogin(this.userName, this.password).subscribe(res => {
      console.log(res)
      this.loginService.user_id = JSON.parse(res)['user_id']
      localStorage.setItem('user_id_rt', this.loginService.user_id);
      this.error = JSON.parse(res)['error']
      this.loginService.user_name_title = JSON.parse(res)['user_name'];
      localStorage.setItem('user_name_title', this.loginService.user_name_title);
      if (this.loginService.user_id !== null) {
        location.reload();
      }
    });
  }


  ngOnInit() {}
}
