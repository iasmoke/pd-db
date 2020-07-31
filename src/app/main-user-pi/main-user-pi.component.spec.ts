import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { MainUserPiComponent } from './main-user-pi.component';

describe('MainUserPiComponent', () => {
  let component: MainUserPiComponent;
  let fixture: ComponentFixture<MainUserPiComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ MainUserPiComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(MainUserPiComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
