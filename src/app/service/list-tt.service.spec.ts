import { TestBed } from '@angular/core/testing';

import { ListTtService } from './list-tt.service';

describe('ListTtService', () => {
  let service: ListTtService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ListTtService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
