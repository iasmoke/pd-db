import { TestBed } from '@angular/core/testing';

import { TelegramSendService } from './telegram-send.service';

describe('TelegramSendService', () => {
  let service: TelegramSendService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(TelegramSendService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
