import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ListTtComponent } from './list-tt.component';

describe('ListTtComponent', () => {
  let component: ListTtComponent;
  let fixture: ComponentFixture<ListTtComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ListTtComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ListTtComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
