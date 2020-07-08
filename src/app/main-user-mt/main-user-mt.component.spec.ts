import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { MainUserMtComponent } from './main-user-mt.component';

describe('MainUserMtComponent', () => {
  let component: MainUserMtComponent;
  let fixture: ComponentFixture<MainUserMtComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ MainUserMtComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(MainUserMtComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
