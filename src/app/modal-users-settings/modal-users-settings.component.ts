import { Component, Inject, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { MatSnackBar } from '@angular/material/snack-bar';
import { DialogData } from '../main/main.component';
import * as moment from 'moment';
import { MustMatch } from '../login/must-match.validator';
import { LoginService } from '../service/login.service';


@Component({
  templateUrl: './modal-users-settings.component.html',
  styleUrls: ['./modal-users-settings.component.scss']
})
export class ModalUsersSettingsComponent implements OnInit {

  registerForm:FormGroup
  modal_alert_message:any

  constructor(
    public dialogRef: MatDialogRef<ModalUsersSettingsComponent>,
    @Inject(MAT_DIALOG_DATA) public data: DialogData,
    public formBuilder: FormBuilder,
    private _snackBar: MatSnackBar,
    private loginService:LoginService
  ) { }

  get f() { return this.registerForm.controls; }

  ngOnInit(): void {
    this.registerForm = this.formBuilder.group({
      userName: new FormControl('',Validators.required),
      password: new FormControl('',[Validators.required, Validators.minLength(6)]),
      confirmPassword: new FormControl('',Validators.required),
      first_name: new FormControl('',Validators.required),
      last_name: new FormControl('',Validators.required),
      user_role: new FormControl('',Validators.required),
      list_tt_access: new FormControl('',Validators.required),
      distribution_access: new FormControl('',Validators.required),
      
    }, {
      validator: MustMatch('password', 'confirmPassword')
    });
  }

  register() {
    if (this.registerForm.invalid) {
      return console.log('false');
    } else {
      this.loginService.registerUser(this.registerForm.value).subscribe(res => {
        this.modal_alert_message = JSON.parse(res).toString()
        console.log(this.modal_alert_message);
        if (this.modal_alert_message === 'Регистрация успешна') {
          this.registerForm.reset()
      //     this.get_users_settings()
      //     $("#register_user").modal("hide")
      //     $("#myModalError_register").modal('show');
      //     setTimeout(function () {
      //       $("#myModalError_register").modal('hide');
          // }, 2000);
        }
      });
    }
  }

}
