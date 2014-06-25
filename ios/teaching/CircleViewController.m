//
//  CircleViewController.m
//  teaching
//
//  Created by kidliuxu on 14-4-25.
//  Copyright (c) 2014年 icesmart. All rights reserved.
//

#import "CircleViewController.h"
#import "CommonViewController.h"

@interface CircleViewController ()

@end

@implementation CircleViewController

@synthesize URLStr;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewWillAppear:(BOOL)animated
{
    if(self.isShowedLoginView)
    {
        self.isShowedLoginView = NO;
        [self startRequestWebView];
    }
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    // Do any additional setup after loading the view.
    [self loadUser];
    [self addMenuButton];
    NSBundle *bundle = [NSBundle bundleForClass:[self class]];
    [self setNavTitle:[bundle objectForInfoDictionaryKey:@"APP_TITLE_CIRCLE"]];
    [self initWebView];
    //self.webView.scrollView.bounces = YES;
    //self.webView.frame = CGRectMake(0, 42, self.webView.frame.size.width, self.webView.frame.size.height - 42);
    //#if TARGET_VERSION_LITE==1
    self.URLStr = URLMAKER(URL_CIRCLE, [self getUserSid]);
    [self startRequestWebView];

}

- (void)startRequestWebView
{
    NSURLRequest *request =[NSURLRequest requestWithURL:[NSURL URLWithString:self.URLStr]];
    [self.webView loadRequest:request];
}

-(BOOL) webView:(UIWebView *)webView shouldStartLoadWithRequest:(NSURLRequest *)request navigationType:(UIWebViewNavigationType)navigationType
{


    NSLog(@"request %@",[request URL]);

    if (navigationType == UIWebViewNavigationTypeLinkClicked)
    {

        NSURL *URL = [request URL];


        NSLog(@"NSURL %@,%@,%@,%@",[URL baseURL],[URL lastPathComponent],[URL parameterString],[URL standardizedURL]);

        NSLog(@"request url :%@",[URL scheme]);

        if ([[URL scheme] isEqualToString:@"http"])
        {
            CommonViewController *ctl = [[CommonViewController alloc]initWithUrl:[request URL] ];

            [self.navigationController pushViewController:ctl animated:YES];
            [ctl release];


        }else{

            //Not a URL
            
        }
        
        return NO;
        
    }
    
    return YES;
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

/*
#pragma mark - Navigation

// In a storyboard-based application, you will often want to do a little preparation before navigation
- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
    // Get the new view controller using [segue destinationViewController].
    // Pass the selected object to the new view controller.
}
*/

@end
