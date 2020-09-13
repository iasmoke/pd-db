import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ModalListTtComponent } from './modal-list-tt.component';

describe('ModalListTtComponent', () => {
  let component: ModalListTtComponent;
  let fixture: ComponentFixture<ModalListTtComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ModalListTtComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ModalListTtComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
