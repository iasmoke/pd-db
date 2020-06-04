import { TestBed } from '@angular/core/testing';

import { TradingSetting } from './trading_setting.service';

describe('CheckboxService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: TradingSetting = TestBed.get(TradingSetting);
    expect(service).toBeTruthy();
  });
});
