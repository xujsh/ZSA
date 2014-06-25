//
//  AnnounceViewController.m
//  teaching
//
//  Created by merlin on 14-1-16.
//  Copyright (c) 2014年 icesmart. All rights reserved.
//

#import "AnnounceViewController.h"
#import "LoginViewController.h"

@interface AnnounceViewController ()

@end

@implementation AnnounceViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
	if(![self isGuest])
    {
        [self setNavTitle:@"登录-通知"];
        
        LoginViewController *loginview = [[LoginViewController alloc]init];
        
        [self.view addSubview: loginview.view];
    }
    else
    {
        [self setNavTitle:@"通知"];
        
        [self loadUser];
        
        //需要地址
        //NSString * logUrl = [NSString stringWithFormat:@"http://coursement.test.icesmart.cn/index.php/地址路径?sid=%@",[self.member valueForKey:@"sid"]];
        
        NSString *logUrl = URLMAKER(URL_NOTICE, [self getUserSid]);
        [self initWebView];
        //self.webView.frame = CGRectMake(0, 42, self.webView.frame.size.width, self.webView.frame.size.height - 42);
        NSURLRequest *request =[NSURLRequest requestWithURL:[NSURL URLWithString:logUrl]];
        [self.webView loadRequest:request];
        
        
    }
    
    [self addMenuButton];
}

-(BOOL) webView:(UIWebView *)webView shouldStartLoadWithRequest:(NSURLRequest *)request navigationType:(UIWebViewNavigationType)navigationType
{


    NSLog(@"announceviewcontroller request %@",[request URL]);

    if (navigationType == UIWebViewNavigationTypeLinkClicked) {

        NSURL *URL = [request URL];


        NSLog(@"NSURL %@,%@,%@,%@",[URL baseURL],[URL lastPathComponent],[URL parameterString],[URL standardizedURL]);

        NSLog(@"announceviewcontroller request url :%@",[URL scheme]);

        if ([[URL scheme] isEqualToString:@"http"]) {




            AnnounceDetailViewController *ctl = [[AnnounceDetailViewController alloc]initWithUrl:[request URL] ];

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

@end
