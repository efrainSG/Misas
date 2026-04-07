import { TestBed } from '@angular/core/testing';

import { TipoLocacionService } from './tipo-locacion-service';

describe('TipoLocacionService', () => {
  let service: TipoLocacionService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(TipoLocacionService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
