import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { MainUserHrComponent } from './main-user-hr.component';

describe('MainUserHrComponent', () => {
  let component: MainUserHrComponent;
  let fixture: ComponentFixture<MainUserHrComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ MainUserHrComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(MainUserHrComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
