import { TestBed } from '@angular/core/testing';

import { BacktestsService } from './backtests.service';

describe('BacktestsService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: BacktestsService = TestBed.get(BacktestsService);
    expect(service).toBeTruthy();
  });
});
