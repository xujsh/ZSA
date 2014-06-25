//
//  HomeViewController.m
//  teaching
//
//  Created by merlin on 13-12-18.
//  Copyright (c) 2013年 icesmart. All rights reserved.
//

#import "HomeViewController.h"
#import "CourseInfoViewController.h"
#import "LoginViewController.h"
#import "SearchViewController.h"

@interface HomeViewController ()

@end

@implementation HomeViewController

@synthesize webView, homeURL, hotURL, classURL;

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
    [self loadUser];
	[self addMenuButton];
    [self addSearchButton];

    
    [self setNavTitle:APP_TITLE];
    [self addTabBar];
    [self initWebView];
    self.webView.scrollView.bounces = YES;
    self.webView.frame = CGRectMake(0, 42, self.webView.frame.size.width, self.webView.frame.size.height - 42);
    [self initURL];
    //#if TARGET_VERSION_LITE==1
    [self startRequestWebView];


    
}

- (void)viewWillAppear:(BOOL)animated
{
    if(self.isShowedLoginView)
    {
        self.isShowedLoginView = NO;
        [self startRequestWebView];
    }
}

- (void) startRequestWebView
{
    //[self initWebView];
    //self.webView.scrollView.bounces = YES;
    [self initURL];
    NSLog(@"homeURL %@", self.homeURL);
    NSURLRequest *request =[NSURLRequest requestWithURL:[NSURL URLWithString:self.homeURL]];
    [self.webView loadRequest:request];
}

- (void) initURL
{
    [self loadUser];
    self.homeURL = URLMAKER(URL_HOMEPAGE, [self getUserSid]);// @"http://coursement.test.icesmart.cn/index.php/Index/iosindex/rtid/new";
    self.hotURL = URLMAKER(URL_HOTURL, [self getUserSid]);//@"http://coursement.test.icesmart.cn/index.php/Index/iosindex/rtid/hot";
    self.classURL = URLMAKER(URL_CLASSURL, [self getUserSid]);//@"http://coursement.test.icesmart.cn/index.php/Index/iosindex/rtid/type";
    /*if( TARGET_VERSION_LITE == 1)
    {
        self.homeURL = @"http://lxhg.test.icesmart.cn/index.php/Index/iosindex/rtid/new";
        self.hotURL = @"http://lxhg.test.icesmart.cn/index.php/Index/iosindex/rtid/hot";
        self.classURL = @"http://lxhg.test.icesmart.cn/index.php/Index/iosindex/rtid/type";
    }*/
}

- (void)addTabBar
{
    //LoginViewController *logingVC = [[LoginViewController alloc] init];
    
    UIImageView *tabBarBG = [[[UIImageView alloc] initWithImage:[UIImage imageNamed:@"HomePage_TabbarBG.png"]] autorelease];
    [self.view addSubview:tabBarBG];


    //UICheckBox *checkBox1 = [[UICheckBox alloc] initWithOnFile:@"HomePage_TabbarBtnBG.png" OffFile:@"" labelStr:@"最新"];
    UICheckBox *checkBox1 = [[UICheckBox alloc] initWithOnFile:@"HomePage_TabbarBtnBG.png" OffFile:@"" labelStr:@"最新" onColor:0x284050 offColor:0x78858d];
    [checkBox1 setLabelFont:[UIFont systemFontOfSize:13]];
    UICheckBox *checkBox2 = [[UICheckBox alloc] initWithOnFile:@"HomePage_TabbarBtnBG.png" OffFile:@"" labelStr:@"热门" onColor:0x284050 offColor:0x78858d];
    [checkBox2 setLabelFont:[UIFont systemFontOfSize:13]];
    UICheckBox *checkBox3 = [[UICheckBox alloc] initWithOnFile:@"HomePage_TabbarBtnBG.png" OffFile:@"" labelStr:@"分类" onColor:0x284050 offColor:0x78858d];
    [checkBox3 setLabelFont:[UIFont systemFontOfSize:13]];

    UICheckBoxGroup *checkBoxGroup = [UICheckBoxGroup initWithUIView:checkBox1, checkBox2, checkBox3, nil];
    [checkBoxGroup alignItemsHorizontallyWithPadding:1];
    [checkBoxGroup setShowItemByIndex:0];
    [checkBoxGroup setDelegate:self];
    [self.view addSubview:checkBoxGroup];
}

- (void) didUICheckBoxGroupValeuChange:(id)sender UICheckBox:(UICheckBox *)checkBox
{
    NSLog(@"tag: %i", checkBox.tag);
    int clickID = checkBox.tag;
    NSString *url = @"";
    if(clickID == 0)
    {
        url = self.homeURL;
    }
    else if(clickID == 1)
    {
        url = self.hotURL;
    }
    else if(clickID == 2)
    {
        url = self.classURL;
    }
    //[self changeSidURLByURLString:url changeSid:@"thisisanewsid"];
    NSLog(@"req: %@", url);
    NSURLRequest *request =[NSURLRequest requestWithURL:[NSURL URLWithString:url]];
    [self.webView loadRequest:request];
}

- (void) showSearch
{
    [self loadUser];
    NSURL *URL = [NSURL URLWithString:URLMAKERS(URL_SEARCH, [self getUserSid])];
    //CommonViewController *classInfo = [[CommonViewController alloc] initWithUrl:URL];
    SearchViewController *classInfo = [[SearchViewController alloc] initWithUrl:URL];
    [self.navigationController pushViewController:classInfo animated:YES];
}

-(BOOL) webView:(UIWebView *)webView shouldStartLoadWithRequest:(NSURLRequest *)request navigationType:(UIWebViewNavigationType)navigationType
{
    
    
    NSLog(@"web view request %@",[request URL]);

    if (navigationType == UIWebViewNavigationTypeLinkClicked) {
        
        NSURL *URL = [request URL];
        
        
        NSLog(@"NSURL %@,%@,%@,%@",[URL baseURL],[URL lastPathComponent],[URL parameterString],[URL standardizedURL]);
                
        NSLog(@"request url :%@",[URL scheme]);
        
        if ([[URL scheme] isEqualToString:@"http"]) {
            
            
            
            
            CourseInfoViewController *ctl = [[CourseInfoViewController alloc]initWithUrl:[request URL] ];
            
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
