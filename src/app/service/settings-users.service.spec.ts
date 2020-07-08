import { TestBed } from '@angular/core/testing';

import { SettingsUsersService } from './settings-users.service';

describe('SettingsUsersService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: SettingsUsersService = TestBed.get(SettingsUsersService);
    expect(service).toBeTruthy();
  });
});
