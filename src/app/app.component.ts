import { Component } from '@angular/core';
import { LoginService } from './service/login.service';
import { HttpClient } from '@angular/common/http';
import { FormBuilder, Validators, FormGroup, FormControl } from '@angular/forms';
import { TimerService } from './service/timer.service';
// import { TimerObservable } from "rxjs/observable/TimerObservable";
import 'rxjs/add/operator/takeWhile'
import { TradingSetting } from './service/trading_setting.service';
import { MatDialog } from '@angular/material';
// import { ModalOpenLogComponent } from './modal-open-log/modal-open-log.component';
import { BacktestsService } from './service/backtests.service';
import { DataService } from './service/data.service';
import { min } from 'rxjs/operators';
import { MustMatch } from '././login/must-match.validator';
// import { TradingSettingsComponent } from './trading-settings/trading-settings.component';
import { timingSafeEqual } from 'crypto';


declare var $: any;

export interface ModalLastLog {
  log_text: any;
}



@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {

  title = 'Pizza Day';
  user_id = this.loginService.user_id;
  user_name_title = this.loginService.user_name_title;
  program_v = 'v2.12';
  backgroundColorToggle = 'primary';

  backtest_list_type = [];

  status_research = '';

  //page Menu
  pageOne = this.user_id !== null ? true : false;
  userPage = false;
  backTestReport = false;
  login = this.user_id === null ? true : false;
  statistic_table = false;
  graphs = false;

  disRun = false;

  error_time_function: boolean;
  interval = 10000;

  error: any;

  mess_backtest: any;
  backtest_list: any;
  backtest_error: any;


  backtest_id_one: any;

  registerForm: FormGroup;
  submitted = false;

  error_register: any;

  status_text: any;
  progress_tooltip: any;
  log_error_text: any;
  status_text_db: any;
  bool_button_err = false;
  status_err: any;

  error_bt_one: any;
  user_status_research: any;

  alert_err = false;
  alert_logic = false;

  validTradingLogic = false;
  validMess:any;

  constructor(
    private loginService: LoginService,
    private http: HttpClient,
    private formBuilder: FormBuilder,
    // private timer: TimerService,
    public dialog: MatDialog,
    // private backtestService: BacktestsService,
    private dataService: DataService,
    public tradingSettings: TradingSetting
  ) {

    this.backtestService.getBacktestList(this.loginService.user_id).subscribe(res => {
      this.backtest_list = JSON.parse(res)['backtest_list'];
      console.log(this.backtest_list);
    });
    this.backtestService.checkStatus(this.loginService.user_id).subscribe(res => {
      this.user_status_research = JSON.parse(res);
      if (this.user_status_research === 1) {
        this.disRun = true;
        this.readStatuts();
        this.error_time_function = true;
      }
    });

  }

  clickType() {
    console.log(this.backtest_list_type);
  }

  checkError() {
    this.backtestService.checkError(this.loginService.user_id).subscribe(res => {
      this.status_err = JSON.parse(res);
      if (this.status_err === 1) {
        this.error_time_function = false;
        this.disRun = false;
        this.bool_button_err = true;
        this.status_text = ""
      }
    })
  }

  // readStatuts() {
  //   console.log(this.error_time_function);
  //   TimerObservable.create(0, this.interval)
  //     //функция остановки запроса интервала 
  //     .takeWhile(() => this.error_time_function)
  //     .subscribe(() => {
  //       this.backtestService.readProgressStatus(this.loginService.user_id).subscribe(res => {
  //         console.log(res);
  //         this.status_text = JSON.parse(res)['a'];
  //         this.progress_tooltip = JSON.parse(res)['tooltip'];
  //         this.backtestService.checkStatus(this.loginService.user_id).subscribe(res => {
  //           this.user_status_research = JSON.parse(res);
  //           if (this.user_status_research === 0) {
  //             this.disRun = false;
  //             this.error_time_function = false;
  //             this.checkError();
  //           }
  //         });
  //       });
  //     });
  // }

  RunPy() {
    if (this.tradingSettings.Form1.invalid) {
      this.tradingSettings.Form1.get('startDeposit').markAsTouched();
      this.tradingSettings.Form1.get('minTradeQuantity').markAsTouched();
      this.tradingSettings.Form1.get('volumePerLot').markAllAsTouched();
      this.tradingSettings.Form1.get('periodsNumber').markAsTouched();
      this.tradingSettings.Form1.get('minPFtoFilter').markAsTouched();
      this.tradingSettings.Form1.get('maxDDfilter').markAsTouched();
      this.tradingSettings.Form1.get('commissionPerLot').markAllAsTouched();
      if(this.tradingSettings.valueUse_vola_filter === true){
        if(this.tradingSettings.FormUse.invalid){
          this.tradingSettings.FormUse.get('windowAtr').markAsTouched();
          this.tradingSettings.FormUse.get('windowDecil').markAllAsTouched();
          this.tradingSettings.FormUse.get('volaFilterValue').markAllAsTouched();
          return console.log('err_use');
        }
      }
      return console.log('err');
    }
    if(this.tradingSettings.valueUse_vola_filter === true){
      if(this.tradingSettings.FormUse.invalid){
        this.tradingSettings.FormUse.get('windowAtr').markAsTouched();
        this.tradingSettings.FormUse.get('windowDecil').markAllAsTouched();
        this.tradingSettings.FormUse.get('volaFilterValue').markAllAsTouched();
        return console.log('err_use');
      }
    }
    this.dataService.statusDB().subscribe(res => {
      console.log(res);
      this.status_text_db = JSON.parse(res).toString()
      if (this.status_text_db === "influxdb online") {
        this.status_research = "";
        this.disRun = true;
        this.error_time_function = true;
        this.bool_button_err = false;
        this.backtestService.updateUsersSettings(this.loginService.user_id).subscribe(res => {
          console.log(res);
        })

        if (this.backtest_list_type.length > 0) {
          this.loginService.getSettingsUser(this.loginService.user_id).subscribe(res_user => {
            this.backtestService.user_server = JSON.parse(res_user);
            this.backtestService.selectStatusResearchTrue(this.loginService.user_id).subscribe(res_status => {
              this.backtestService.updateUsersSettings(this.loginService.user_id).subscribe(res_clear => {
                this.readStatuts();
                this.backtestService.RunPy(this.user_id, this.backtest_list_type).subscribe(res_run => {
                  console.log(res_run);
                  this.status_research = res_run.toString();
                  this.bool_button_err = this.status_research === "error" ? true : false;
                  this.error_time_function = false;
                  this.disRun = false;
                  this.backtestService.readProgressStatus(this.loginService.user_id).subscribe(res => {
                    this.status_text = JSON.parse(res)['a'];
                    this.progress_tooltip = JSON.parse(res)['tooltip'];
                  });
                });
              });
            });
          });
        } else {
          this.loginService.getSettingsUser(this.loginService.user_id).subscribe(res_user => {
            this.backtestService.user_server = JSON.parse(res_user);
            this.backtestService.addBacktestOne(this.loginService.user_id).subscribe(res_bt => {
              console.log(res);
              this.error = JSON.parse(res_bt)['err'];
              if (this.error === "good") {
                this.backtestService.updateUsersSettings(this.loginService.user_id).subscribe(res_clear => {
                  this.readStatuts();
                  this.backtest_id_one = JSON.parse(res_bt)['backtest_id_py'];
                  this.backtestService.RunPy(this.user_id, this.backtest_id_one).subscribe(res_run => {
                    console.log(res_run);
                    this.status_research = res_run.toString();
                    this.bool_button_err = this.status_research === "error" ? true : false;
                    this.error_time_function = false;
                    this.disRun = false;
                    this.backtestService.readProgressStatus(this.loginService.user_id).subscribe(res => {
                      this.status_text = JSON.parse(res)['a'];
                      this.progress_tooltip = JSON.parse(res)['tooltip'];
                    });
                  });
                })
              } else {
                this.alert_err = true;
                this.disRun = false;
                this.error_time_function = false;
                this.status_text = ""
              }
            })
          })
        }
      }
      // this.disRun = true;
      // this.error_time_function = true;
      // this.count_mess_err = 0;
      // if (this.backtest_list_type.length > 0) {
      //   // this.readStartList()
      //   this.backtestService.clickRunList(this.backtest_list_type, this.loginService.user_id).subscribe(res => {
      //     console.log(res);
      //     this.error = JSON.parse(res);
      //     if (this.error === "Script completed") {
      //       $("#script_completed").modal('show');
      //       this.disRun = false;
      //       console.log(this.disRun);
      //       this.error_time_function = false;
      // }
      // });
      // this.readStart();

      //   this.backtestService.clickRun(this.loginService.user_id).subscribe(res => {
      //     console.log(res);
      //     this.error = JSON.parse(res)['err'];
      //     console.log(this.error_time_function);
      //     if (this.error === "Script completed") {
      //       $("#script_completed").modal('show');
      //       this.disRun = false;
      //       this.error_time_function = false;
      //     } else {
      //       $("#myModalError_run").modal('show');
      //       setTimeout(function () {
      //         $("#myModalError_run").modal('hide');
      //       }, 2000);
      //       this.disRun = false;
      //       this.error_time_function = false;
      //     }
      //   })
      // }
      //   }
      //       else {
      //   $("#db_influx_connect").modal('show');
      // }
    })
  }

  selectMenuItem(items) {
    this.pageOne = false;
    this.userPage = false;
    this.backTestReport = false;
    this.statistic_table = false;
    this.graphs = false
    this[items] = true;
    
  }
  logout() {
    localStorage.removeItem('user_id_rt');
    location.reload();
  }


  openLogError(): void {

    this.backtestService.readErrorLog(this.loginService.user_id).subscribe(res => {
      console.log(res);
      this.log_error_text = JSON.parse(res);
      this.dialog.open(ModalOpenLogComponent, {
        height: '500px',
        width: '1000px',
        data: { log_text: this.log_error_text }
      });
    });

  }
  
  addBacktestList() {
    if (this.tradingSettings.Form1.invalid) {
      this.tradingSettings.Form1.get('startDeposit').markAsTouched();
      this.tradingSettings.Form1.get('minTradeQuantity').markAsTouched();
      this.tradingSettings.Form1.get('volumePerLot').markAllAsTouched();
      this.tradingSettings.Form1.get('periodsNumber').markAsTouched();
      this.tradingSettings.Form1.get('minPFtoFilter').markAsTouched();
      this.tradingSettings.Form1.get('maxDDfilter').markAsTouched();
      this.tradingSettings.Form1.get('commissionPerLot').markAllAsTouched();
      if(this.tradingSettings.valueUse_vola_filter === true){
        if(this.tradingSettings.FormUse.invalid){
          this.tradingSettings.FormUse.get('windowAtr').markAsTouched();
          this.tradingSettings.FormUse.get('windowDecil').markAllAsTouched();
          this.tradingSettings.FormUse.get('volaFilterValue').markAllAsTouched();
          return console.log('err_use');
        }
      }
      return console.log('err');
    }
    if(this.tradingSettings.valueUse_vola_filter === true){
      if(this.tradingSettings.FormUse.invalid){
        this.tradingSettings.FormUse.get('windowAtr').markAsTouched();
        this.tradingSettings.FormUse.get('windowDecil').markAllAsTouched();
        this.tradingSettings.FormUse.get('volaFilterValue').markAllAsTouched();
        return console.log('err_use');
      }
    }
    this.backtestService.addBacktestList(this.loginService.user_id).subscribe(res => {
      console.log(res);
      
      this.error = JSON.parse(res)['err']
      console.log(this.error);
      if (this.error === "Backtest added") {
        $("#backtest_add").modal('show');
        setTimeout(function () {
          $("#backtest_add").modal('hide');
        }, 3000);
      } else {
        this.alert_err = true;
        // $("#backtest_add_err").modal('show');
        // setTimeout(function () {
        //   $("#backtest_add_err").modal('hide');
        // }, 5000);
      }
    });
  }
 
  registerUser() {
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

  closeAlert(){
    this.alert_err = false;
    $(".alert").alert('dispose')
  }



  ngOnInit() {
    this.registerForm = this.formBuilder.group({
      userName: ['', Validators.required],
      password: ['', [Validators.required, Validators.minLength(6)]],
      confirmPassword: ['', Validators.required],
      serverName: ['', Validators.required],
      threads: ['', [Validators.required, Validators.max(50)]]
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
