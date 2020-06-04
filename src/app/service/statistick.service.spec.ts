import { TestBed } from '@angular/core/testing';

import { StatistickService } from './statistick.service';

describe('StatistickService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: StatistickService = TestBed.get(StatistickService);
    expect(service).toBeTruthy();
  });
});
