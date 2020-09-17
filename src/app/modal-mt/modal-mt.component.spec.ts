import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ModalMtComponent } from './modal-mt.component';

describe('ModalMtComponent', () => {
  let component: ModalMtComponent;
  let fixture: ComponentFixture<ModalMtComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ModalMtComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ModalMtComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
