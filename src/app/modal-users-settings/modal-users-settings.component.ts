import { Component, Inject, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { MatSnackBar } from '@angular/material/snack-bar';
import { DialogData } from '../main/main.component';
import { MustMatch } from '../login/must-match.validator';
import { LoginService } from '../service/login.service';


@Component({
  templateUrl: './modal-users-settings.component.html',
  styleUrls: ['./modal-users-settings.component.scss']
})
export class ModalUsersSettingsComponent implements OnInit {

  registerForm: FormGroup
  modal_alert_message: any

  constructor(
    public dialogRef: MatDialogRef<ModalUsersSettingsComponent>,
    @Inject(MAT_DIALOG_DATA) public data: DialogData,
    public formBuilder: FormBuilder,
    private _snackBar: MatSnackBar,
    private loginService: LoginService
  ) { }

  get f() { return this.registerForm.controls; }

  ngOnInit(): void {
    this.registerForm = this.formBuilder.group({
      userName: new FormControl('', Validators.required),
      password: new FormControl('', [Validators.required, Validators.minLength(6)]),
      confirmPassword: new FormControl('', Validators.required),
      first_name: new FormControl('', Validators.required),
      last_name: new FormControl('', Validators.required),
      user_role: new FormControl('', Validators.required),
      list_tt_access: new FormControl(''),
      distribution_access: new FormControl(''),

    }, {
      validator: MustMatch('password', 'confirmPassword')
    });
  }

  register() {
    switch (this.registerForm.invalid) {
      case true:
        console.log('false');
        break;
      default:
        this.loginService.registerUser(this.registerForm.value).subscribe(res => {
          this.modal_alert_message = JSON.parse(res).toString()
          console.log(this.modal_alert_message);
          switch (this.modal_alert_message) {
            case 'Регистрация успешна':
              this.dialogRef.close(this.modal_alert_message)
              break;
            default:
              this._snackBar.open(this.modal_alert_message, '', {
                duration: 7000,
                horizontalPosition: 'center',
                verticalPosition: 'top',
                panelClass: 'alert-style-error'
              });
              break;
          }
        });
        break;
    }
  }
}
