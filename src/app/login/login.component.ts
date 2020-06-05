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
  registerForm: FormGroup;
  submitted = false;

  error_register: any;

  hide_register

  constructor(
    private loginService: LoginService,
    private http: HttpClient,
    private formBuilder: FormBuilder,
  ) {

  }

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
  register() {
    this.submitted = true;
    if (this.registerForm.invalid) {
      return console.log('false');
    } else {
      this.loginService.registerUser(this.registerForm.value).subscribe(res => {
        this.error_register = JSON.parse(res).toString()
        console.log(this.error_register);
        if (this.error_register === 'Registration successful') {
          $("#register_user").modal("hide")
          $("#myModalError_register").modal('show');
          setTimeout(function () {
            $("#myModalError_register").modal('hide');
          }, 2000);
        }
      });
    }

  }

  ngOnInit(): void {
    this.registerForm = this.formBuilder.group({
      userName: ['', Validators.required],
      password: ['', [Validators.required, Validators.minLength(6)]],
      confirmPassword: ['', Validators.required],
      position: ['', Validators.required],
      user_role: ['', Validators.required]
    }, {
      validator: MustMatch('password', 'confirmPassword')
    });
  }

  get f() { return this.registerForm.controls; }


  onSubmit() {
    this.submitted = true;

    // stop here if form is invalid
    if (this.registerForm.invalid) {
      return;
    }
  }
}
