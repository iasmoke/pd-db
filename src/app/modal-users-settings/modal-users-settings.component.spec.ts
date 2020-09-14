import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ModalUsersSettingsComponent } from './modal-users-settings.component';

describe('ModalUsersSettingsComponent', () => {
  let component: ModalUsersSettingsComponent;
  let fixture: ComponentFixture<ModalUsersSettingsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ModalUsersSettingsComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ModalUsersSettingsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
