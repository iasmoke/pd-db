import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { TelegramSendComponent } from './telegram-send.component';

describe('TelegramSendComponent', () => {
  let component: TelegramSendComponent;
  let fixture: ComponentFixture<TelegramSendComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ TelegramSendComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(TelegramSendComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
