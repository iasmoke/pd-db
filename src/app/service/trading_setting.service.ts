import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

import { FormControl, Validators, FormBuilder, FormGroup } from '@angular/forms';

@Injectable({
  providedIn: 'root'
})
export class TradingSetting {

  valueStart_deposit: any;
  valuePeriods_number: any;
  valueMin_pf_to_filter: any;
  valueMin_trade_quantity: any;
  valueCommission_per_lot: any;
  valueVolume_per_lot: any;
  valueMax_dd_filter: any;
  
 

  disabledRunButton = true;

  valueWindow_decil: any;
  valueWindow_atr: any;
  valueVola_filter_value: any;
  valueUse_vola_filter: boolean;

  Form1: FormGroup
  FormUse:FormGroup

  constructor(private http: HttpClient,private formBuilder: FormBuilder)
  {}


  tradingChange(user_id, parameter_name, parameter_value) {
    return this.http.post(
      './assets/php/trading_settings.php',
      JSON.stringify(
        {
          'user_id': user_id,
          'parameter_name': parameter_name,
          'parameter_value': parameter_value

        }
      ),
      { responseType: 'text' }
    );
  }

  getTradingSetting(user_id,parameter_name) {
    
    return this.http.post(
      './assets/php/get_trading_settings.php',
      JSON.stringify(
        {
          'user_id': user_id,
          'parameter_name': parameter_name
        }
      ),
      { responseType: 'text' }
    );

  }

  checkboxTradingLogics(user_id, parameter_name, parameter_value) {

    return this.http.post(
      './assets/php/trading_logics.php',
      JSON.stringify(
        {
          'user_id': user_id,
          'parameter_name': parameter_name,
          'parameter_value': parameter_value

        }
      ),
      { responseType: 'text' }
    );
  }

  getTradingLogics(user_id, parameter_name) {
    return this.http.post(
      './assets/php/get_trading_logics.php',
      JSON.stringify(
        {
          'user_id': user_id,
          'parameter_name': parameter_name

        }
      ),
      { responseType: 'text' }
    );

  }

  timeFilterResampleSelectType(user_id, parameter_name, select_type) {
    return this.http.post(
      './assets/php/time_filter_resample_select_type.php',
      JSON.stringify(
        {
          'user_id': user_id,
          'parameter_name': parameter_name,
          'select_type': select_type

        }
      ),
      { responseType: 'text' }
    );
  }

  timeFilterResample(user_id) {
    return this.http.post(
      './assets/php/time_filter_resample.php',
      JSON.stringify(
        {
          'user_id': user_id
        }
      ),
      { responseType: 'text' }
    );
  }

  timeFilterResampleSelect(user_id, value_name) {
    return this.http.post(
      './assets/php/time_filter_resample_select.php',
      JSON.stringify(
        {
          'user_id': user_id,
          'value_name': value_name
        }
      ),
      { responseType: 'text' }
    );
  }

  volaFilterSide(user_id) {
    return this.http.post(
      './assets/php/vola_filter_side.php',
      JSON.stringify(
        {
          'user_id': user_id
        }
      ),
      { responseType: 'text' }
    );
  }

  volaFilterSideSelect(user_id, vola_value_name) {
    return this.http.post(
      './assets/php/vola_filter_side_select.php',
      JSON.stringify(
        {
          'user_id': user_id,
          'vola_value_name': vola_value_name
        }
      ),
      { responseType: 'text' }
    );
  }


// disabledRun() {
//   ((this.valueStart_deposit < 100) || (this.valueStart_deposit > 1000000) || (this.valueStart_deposit === 'null') || (this.valueStart_deposit === undefined) ||
//   (this.valuePeriods_number < 2) || (this.valuePeriods_number > 100) || (this.valuePeriods_number === 'null') || (this.valuePeriods_number === undefined) ||
//   (this.valueMin_pf_to_filter < 0) || (this.valueMin_pf_to_filter > 100.0) || (this.valueMin_pf_to_filter === 'null') || (this.valueMin_pf_to_filter === undefined) ||
//   (this.valueMin_trade_quantity < 1) || (this.valueMin_trade_quantity > 5000) || (this.valueMin_trade_quantity === 'null') || (this.valueMin_trade_quantity === undefined) ||
//   (this.valueCommission_per_lot < 0) || (this.valueCommission_per_lot > 1000.0) || (this.valueCommission_per_lot === 'null') || (this.valueCommission_per_lot === undefined) ||
//   (this.valueVolume_per_lot < 1) || (this.valueVolume_per_lot > 1000000) || (this.valueVolume_per_lot === 'null') || (this.valueVolume_per_lot === undefined) ||
//   (this.valueMax_dd_filter < 1) || (this.valueMax_dd_filter > 100) || (this.valueMax_dd_filter === 'null') || (this.valueMax_dd_filter === undefined) ||
//   (this.valueUse_vola_filter === true ?
//   (this.valueVola_filter_value < 0) || (this.valueVola_filter_value > 11) || (this.valueVola_filter_value === 'null') || (this.valueVola_filter_value === undefined)||
//   (this.valueWindow_decil < 1) || (this.valueWindow_decil > 5000) || (this.valueWindow_decil === 'null') || (this.valueWindow_decil === undefined) ||
//   (this.valueWindow_atr < 1) || (this.valueWindow_atr > 5000) || (this.valueWindow_atr === 'null') || (this.valueWindow_atr === undefined): false)) === true ? this.disabledRunButton = true : this.disabledRunButton = false;
// }

controlValid(){
  this.Form1 = this.formBuilder.group({
    startDeposit: [this.valueStart_deposit,[Validators.required,Validators.min(100),Validators.max(1000000),Validators.pattern('[0-9]{1,7}')]],
    minTradeQuantity: [this.valueMin_trade_quantity, [Validators.required,Validators.min(1),Validators.max(5000),Validators.pattern('[0-9]{1,4}')]],
    volumePerLot: [this.valueVolume_per_lot,[Validators.required,Validators.min(1),Validators.max(1000000),Validators.pattern('[0-9]{1,7}')]],
    periodsNumber: [this.valuePeriods_number,[Validators.required,Validators.min(2),Validators.max(100),Validators.pattern('[0-9]{1,3}')]],
    minPFtoFilter: [this.valueMin_pf_to_filter, [Validators.required,Validators.min(0),Validators.max(100.0),Validators.pattern('[0-9]+([\.,][0-9]+)?')]],
    maxDDfilter: [this.valueMax_dd_filter,[Validators.required,Validators.min(1),Validators.max(100),Validators.pattern('[0-9]{1,3}')]],
    commissionPerLot: [this.valueCommission_per_lot,[Validators.required,Validators.min(0),Validators.max(1000.0),Validators.pattern('[0-9]+([\.,][0-9]+)?')]],
  });
}
controlValidUse(){
    this.FormUse = this.formBuilder.group({
      windowAtr:[this.valueWindow_atr,[Validators.required,Validators.min(1),Validators.max(5000),Validators.pattern('[0-9]{1,4}')]],
      windowDecil:[this.valueWindow_decil,[Validators.required,Validators.min(1),Validators.max(5000),Validators.pattern('[0-9]{1,4}')]],
      volaFilterValue:[this.valueVola_filter_value,[Validators.required,Validators.min(0),Validators.max(11),Validators.pattern('[0-9]{1,2}')]],
    })
  
}


get u() { return this.FormUse.controls;}
get f() { return this.Form1.controls; }

}

