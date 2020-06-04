import { TestBed } from '@angular/core/testing';

import { Features } from './features.service';

describe('ConnectService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: Features = TestBed.get(Features);
    expect(service).toBeTruthy();
  });
});
