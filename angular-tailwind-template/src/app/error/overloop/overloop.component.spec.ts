import { ComponentFixture, TestBed } from '@angular/core/testing';

import { OverloopComponent } from './overloop.component';

describe('OverloopComponent', () => {
  let component: OverloopComponent;
  let fixture: ComponentFixture<OverloopComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [OverloopComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(OverloopComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
