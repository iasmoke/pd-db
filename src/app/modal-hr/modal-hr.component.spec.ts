import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ModalHrComponent } from './modal-hr.component';

describe('ModalHrComponent', () => {
  let component: ModalHrComponent;
  let fixture: ComponentFixture<ModalHrComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ModalHrComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ModalHrComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
