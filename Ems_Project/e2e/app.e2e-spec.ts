import { LOOMEMSClientPage } from './app.po';

describe('loomemsclient App', function() {
  let page: LOOMEMSClientPage;

  beforeEach(() => {
    page = new LOOMEMSClientPage();
  });

  it('should display message saying app works', () => {
    page.navigateTo();
    expect(page.getParagraphText()).toEqual('app works!');
  });
});
