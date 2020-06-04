import { TestBed } from '@angular/core/testing';

import { TradingLogicService } from './trading-logic.service';

describe('TradingLogicService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: TradingLogicService = TestBed.get(TradingLogicService);
    expect(service).toBeTruthy();
  });
});
